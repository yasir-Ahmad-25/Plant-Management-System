<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function dashboard()
    {

        $user = Auth::user(); // returns the logged-in user model

        // Example: access name or email
        $name = Auth::user()->name;
        $email = $user->email;

        # ===== TOP PRODUCTS ===== #
        // Date windows: last 30 days vs the 30 days before that
        $to   = Carbon::now();
        $from = $to->copy()->subDays(30);
        $prevFrom = $from->copy()->subDays(30);
        $prevTo   = $from;

        // Current period revenue per product
        $current = DB::table('product_sales_details as psd')
            ->join('product_sales as ps', 'ps.sale_id', '=', 'psd.sale_id')
            ->join('products as p', 'p.product_id', '=', 'psd.product_id')
            ->leftJoin('product_categories as c', 'c.product_category_id', '=', 'p.product_category_id')
            ->whereBetween('ps.sales_date', [$from, $to])
            ->groupBy('psd.product_id', 'p.product_name', 'c.category_name')
            ->select(
                'psd.product_id',
                'p.product_name',
                DB::raw('COALESCE(c.category_name, "Uncategorized") as category_name'),
                DB::raw('SUM(psd.total) as revenue')
            )
            ->orderByDesc('revenue')
            ->limit(3)
            ->get()
            ->keyBy('product_id');

        // Previous period revenue (for growth%)
        $previous = DB::table('product_sales_details as psd')
            ->join('product_sales as ps', 'ps.sale_id', '=', 'psd.sale_id')
            ->whereBetween('ps.sales_date', [$prevFrom, $prevTo])
            ->groupBy('psd.product_id')
            ->select('psd.product_id', DB::raw('SUM(psd.total) as revenue'))
            ->pluck('revenue', 'product_id');

        // Merge growth%
        $topProducts = $current->values()->map(function ($row) use ($previous) {
            $prev = (float) ($previous[$row->product_id] ?? 0);
            $curr = (float) $row->revenue;
            $growth = $prev > 0 ? (($curr - $prev) / $prev) * 100 : null; // null if no baseline
            return (object)[
                'product_name'  => $row->product_name,
                'category_name' => $row->category_name,
                'revenue'       => $curr,
                'growth'        => $growth, // may be null
            ];
        });

        # ========== Stats Cards ============ #
        // helper for % change (null if no baseline)
        $pct = fn ($curr, $prev) => $prev > 0 ? round((($curr - $prev) / $prev) * 100, 1) : null;

        /* 1) TOTAL REVENUE */
        $currentRevenue = (float) DB::table('product_sales')
            ->whereBetween('sales_date', [$from, $to])
            ->sum('grand_total');

        $prevRevenue = (float) DB::table('product_sales')
            ->whereBetween('sales_date', [$prevFrom, $prevTo])
            ->sum('grand_total');

        $total_revenue = $currentRevenue;                 // for card display
        $revenue_change = $pct($currentRevenue, $prevRevenue);  // for “vs last period”

        /* 2) TOTAL CUSTOMERS (unique) — replaces “Active Customers” */
        $currentCustomers = (int) DB::table('product_sales')
            ->whereBetween('sales_date', [$from, $to])
            ->distinct('customer_number')                 // or 'customer_name' if numbers aren’t reliable
            ->count('customer_number');

        $prevCustomers = (int) DB::table('product_sales')
            ->whereBetween('sales_date', [$prevFrom, $prevTo])
            ->distinct('customer_number')
            ->count('customer_number');

        $total_customers = $currentCustomers;
        $customers_change = $pct($currentCustomers, $prevCustomers);

        /* 3) TOTAL ORDERS — replaces “Conversion Rate” */
        $currentOrders = (int) DB::table('product_sales')
            ->whereBetween('sales_date', [$from, $to])
            ->count();

        $prevOrders = (int) DB::table('product_sales')
            ->whereBetween('sales_date', [$prevFrom, $prevTo])
            ->count();

        $total_orders = $currentOrders;
        $orders_change = $pct($currentOrders, $prevOrders);
        

        # ========  Recent Sales ======= #
        $recentSales = DB::table('product_sales as ps')
                    ->leftJoin('product_sales_details as d', 'd.sale_id', '=', 'ps.sale_id')
                    ->select(
                        'ps.sale_id',
                        'ps.invoice_number',
                        'ps.customer_name',
                        'ps.customer_number',
                        'ps.sales_date',
                        'ps.grand_total',
                        DB::raw('COUNT(d.detail_id) as products_count')
                    )
                    ->groupBy('ps.sale_id','ps.invoice_number','ps.customer_name','ps.customer_number','ps.sales_date','ps.grand_total')
                    ->orderByDesc('ps.sales_date')
                    ->limit(10)                    // show last 10 orders
                    ->get();
        $data = [
            'page_title' => 'Dashboard',
            'user_name' => $name,
            'user_email' => $email,

            'total_revenue'   => $total_revenue,
            'revenue_change'  => $revenue_change,   // e.g., +15.3 or null

            'total_customers' => $total_customers,
            'customers_change'=> $customers_change, // e.g., +8.0 or null

            'total_orders'    => $total_orders,
            'orders_change'   => $orders_change,    // e.g., -2.1 or null

            'topProducts'     => $topProducts,
            'recentSales' => $recentSales,
        ];

        return view('dashboard',$data);
    }

    public function logout()
    {
        Auth::logout();
        session()->regenerate();
        session()->regenerateToken();
        session()->invalidate();
        return redirect()->route('auth.login');
    }

    # ====== SETTINGS SECTION ====== #
    public function settings()
    {
        // Fetch company info
        $companyInfo = CompanyInfo::first();
        if (!$companyInfo) {
            // If no company info exists, create a default one
            $companyInfo = new CompanyInfo();
            $companyInfo->company_name = 'Default Company';
            $companyInfo->company_email = 'company@mail.com';
            $companyInfo->company_phone = '1234567890';
            $companyInfo->company_address = '123 Default St, City, Country';
            $companyInfo->company_logo = null; // or set a default logo path
            $companyInfo->company_slogan = 'Your Slogan Here';
            $companyInfo->save();
        }


        $data = [
            'page_title' => 'Settings',
            'company_info' => $companyInfo,
            'user_email' => Auth::user()->email,
        ];
        return view('settings.index', $data);
    }

    public function update_settings(Request $request)
    {
        $user = Auth::user();

        // Validate inputs
        $request->validate([
            // company
            'company_name'    => 'required|string|max:255',
            'company_email'   => 'nullable|email|max:255',
            'company_phone'   => 'required|string|max:20',
            'company_address' => 'required|string|max:255',
            'company_logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_slogan'  => 'nullable|string|max:255',
            // credentials
            'admin_email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password'=> 'required_with:new_password,new_password_confirmation|string',
            'new_password'    => 'nullable|string|min:3|confirmed', // expects new_password_confirmation
        ]);

        // Wrap in a transaction
        return DB::transaction(function () use ($request, $user) {
            // 1) Update company info
            $companyInfo = CompanyInfo::first();
            if (!$companyInfo) {
                return response()->json(['status' => false, 'error' => 'Company information not found'], 404);
            }
            $companyInfo->company_name    = $request->company_name;
            $companyInfo->company_email   = $request->company_email;   // optional per your form
            $companyInfo->company_phone   = $request->company_phone;
            $companyInfo->company_address = $request->company_address;
            $companyInfo->company_slogan  = $request->company_slogan;

            if ($request->hasFile('company_logo')) {
                // optionally delete old: if ($companyInfo->company_logo) Storage::disk('public')->delete($companyInfo->company_logo);
                $path = $request->file('company_logo')->store('company_logos', 'public');
                $companyInfo->company_logo = $path; // e.g. storage/app/public/company_logos/...
            }

            $companyInfo->save();

            // 2) Update user credentials (email always; password only if provided)
            $user->email = $request->admin_email;

            if ($request->filled('new_password')) {
                // require current password to be correct
                if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                    // throw to rollback transaction
                    abort(response()->json([
                        'status' => false,
                        'error'  => 'Current password is incorrect.'
                    ], 422));
                }
                $user->password = bcrypt($request->new_password);
            }

            $user->save();

            return response()->json([
                'status'  => true,
                'success' => 'Settings updated successfully',
                'company' => $companyInfo,
                'user'    => ['email' => $user->email],
            ]);
        });
    }
    #======= SETTINGS SECTION ====== #


    public function salesOverview(Request $request)
{
    // Accept ?days=7|30|90 — default 7
    $days = (int) $request->query('days', 7);
    if (!in_array($days, [7, 30, 90])) { $days = 7; }

    // Window: last N days INCLUDING today
    $to   = Carbon::now()->endOfDay();
    $from = Carbon::now()->subDays($days - 1)->startOfDay();

    // Aggregate revenue per calendar day
    $rows = DB::table('product_sales')
        ->selectRaw('DATE(sales_date) as d, SUM(grand_total) as revenue')
        ->whereBetween('sales_date', [$from, $to])
        ->groupBy('d')
        ->orderBy('d')
        ->get()
        ->keyBy('d');

    // Build a dense series (fill missing days with 0)
    $period = CarbonPeriod::create($from, '1 day', $to);
    $data = [];
    $max  = 0;

    foreach ($period as $date) {
        $key = $date->toDateString(); // YYYY-MM-DD
        $value = (float) ($rows[$key]->revenue ?? 0);
        $max = max($max, $value);

        // label: Mon, Tue…  (or use $date->format('d M') for 30/90-day views)
        $label = $days === 7 ? $date->format('D') : $date->format('d M');

        $data[] = [
            'date'  => $key,
            'label' => $label,
            'value' => round($value, 2),
        ];
    }

    return response()->json([
        'period' => ['from' => $from->toDateString(), 'to' => $to->toDateString(), 'days' => $days],
        'max'    => $max,
        'data'   => $data,
    ]);
}
}
