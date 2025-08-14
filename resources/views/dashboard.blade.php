<x-base>
    {{-- Define Page Title --}}
    <x-slot name="page_title">{{ $page_title }}</x-slot>

    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .animate-slide-in-right {
            animation: slideInRight 0.4s ease-out forwards;
        }

        .animate-slide-out-right {
            animation: slideOutRight 0.4s ease-in forwards;
        }
    </style>
    
    @if(session('message'))
        <div id="toast-success" class="hidden fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg border border-gray-200" role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
            </div>
            <div class="ms-3 text-sm font-normal">{{session('message')}}</div>
            <button type="button" 
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" 
                    onclick="hideToast()">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif
 
    {{-- <div class="min-h-screen bg-gray-50"> --}}
        <!-- Include Sidebar Component -->
        {{-- <x-sidebar /> --}}

        {{-- Dashboard Content [START]--}}
        {{-- <div class="p-6 sm:ml-64"> --}}
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
                    <p class="text-gray-600 mt-1">Welcome back! Here's what's happening with your business today.</p>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

                <!-- Total Revenue -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                ${{ number_format($total_revenue ?? 0, 2) }}
                            </p>
                            <div class="flex items-center mt-2">
                                @php $chg = $revenue_change; @endphp
                                <span class="text-sm font-medium {{ is_null($chg) ? 'text-gray-500' : ($chg >= 0 ? 'text-green-600' : 'text-red-600') }}">
                                    {{ is_null($chg) ? '—' : (($chg >= 0 ? '+' : '') . $chg . '%') }}
                                </span>
                                <span class="text-gray-500 text-sm ml-2">vs last month</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mt-4">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Customers -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Customers</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ number_format($total_customers ?? 0) }}
                            </p>
                            <div class="flex items-center mt-2">
                                @php $chg = $customers_change; @endphp
                                <span class="text-sm font-medium {{ is_null($chg) ? 'text-gray-500' : ($chg >= 0 ? 'text-green-600' : 'text-red-600') }}">
                                    {{ is_null($chg) ? '—' : (($chg >= 0 ? '+' : '') . $chg . '%') }}
                                </span>
                                <span class="text-gray-500 text-sm ml-2">vs last month</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ number_format($total_orders ?? 0) }}
                            </p>
                            <div class="flex items-center mt-2">
                                @php $chg = $orders_change; @endphp
                                <span class="text-sm font-medium {{ is_null($chg) ? 'text-gray-500' : ($chg >= 0 ? 'text-green-600' : 'text-red-600') }}">
                                    {{ is_null($chg) ? '—' : (($chg >= 0 ? '+' : '') . $chg . '%') }}
                                </span>
                                <span class="text-gray-500 text-sm ml-2">vs last month</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2h6v2m-6-6h6m5-8H4a2 2 0 00-2 2v16l4-4h12l4 4V5a2 2 0 00-2-2z"/>
                            </svg>

                        </div>
                    </div>
                </div>

            </div>


            <!-- Charts and Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Sales Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Sales Overview</h3>

                        <select id="salesRange"
                                class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="7" selected>Last 7 days</option>
                            <option value="30">Last 30 days</option>
                            <option value="90">Last 90 days</option>
                        </select>
                    </div>

                    <!-- Chart area -->
                    <div id="salesChart" class="h-64 flex items-end justify-between space-x-2"></div>
                </div>


                <!-- Top Products -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Top Products</h3>

                    @php
                        $badgeBg = ['bg-blue-100','bg-green-100','bg-yellow-100'];
                        $badgeTx = ['text-blue-600','text-green-600','text-yellow-600'];
                    @endphp

                    <div class="space-y-4">
                        @forelse($topProducts as $i => $p)
                        @php
                            $rank = $i + 1;
                            $bg = $badgeBg[$i] ?? 'bg-gray-100';
                            $tx = $badgeTx[$i] ?? 'text-gray-600';
                            $growthVal = is_null($p->growth) ? null : round($p->growth);
                            $growthClass = is_null($growthVal) ? 'text-gray-500'
                                        : ($growthVal >= 0 ? 'text-green-600' : 'text-red-600');
                            $growthPrefix = is_null($growthVal) ? '' : ($growthVal >= 0 ? '+' : '');
                        @endphp

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 {{ $bg }} rounded-lg flex items-center justify-center">
                                <span class="{{ $tx }} font-semibold">{{ $rank }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $p->product_name }}</p>
                                <p class="text-sm text-gray-500">{{ $p->category_name }}</p>
                            </div>
                            </div>
                            <div class="text-right">
                            <p class="font-semibold text-gray-900">${{ number_format($p->revenue, 0) }}</p>
                            <p class="text-sm {{ $growthClass }}">
                                {{ is_null($growthVal) ? '—' : $growthPrefix . $growthVal . '%' }}
                            </p>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 bg-gray-50 rounded-lg text-gray-500">
                            No sales data yet.
                        </div>
                        @endforelse
                    </div>
                </div>
                
            </div>

            <!-- Recent Orders Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Sales</h3>
                        <a href="{{ route('admin.sales')}}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View all</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentSales as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($row->sales_date)->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $row->invoice_number }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @php
                                    $avatarName = urlencode($row->customer_name ?? 'Customer');
                                    @endphp
                                    <img class="w-8 h-8 rounded-full mr-3"
                                        src="https://ui-avatars.com/api/?name={{ $avatarName }}&background=3b82f6&color=fff"
                                        alt="{{ $row->customer_name }}">
                                    <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $row->customer_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $row->customer_number }}</div>
                                    </div>
                                </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $row->products_count }} {{ Str::plural('product', $row->products_count) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                ${{ number_format((float)$row->grand_total, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-sm text-gray-500">
                                No recent sales.
                                </td>
                            </tr>
                            @endforelse
                            </tbody>

                    </table>
                </div>
            </div>
        {{-- </div> --}}
        {{-- Dashboard Content [END]--}}
    {{-- </div> --}}


    <script>
        function showToast() {
            const toast = document.getElementById('toast-success');
            toast.classList.remove('hidden', 'animate-slide-out-right');
            toast.classList.add('animate-slide-in-right');

            setTimeout(() => {
                hideToast();
            }, 3000);
        }

        function hideToast() {
            const toast = document.getElementById('toast-success');
            toast.classList.remove('animate-slide-in-right');
            toast.classList.add('animate-slide-out-right');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 400);
        }

        function toggleMobileSidebar() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('-translate-x-full');
        }

        @if(session('message'))
            window.onload = showToast;
        @endif

        (function() {
            const chartEl = document.getElementById('salesChart');
            const rangeEl = document.getElementById('salesRange');
            const chartHeight = 220; // px for columns

            async function loadSales(days = 7) {
                chartEl.innerHTML = ''; // clear
                try {
                    const res = await fetch(`{{ route('dashboard.salesOverview') }}?days=${days}`);
                    const json = await res.json();

                    const max = json.max > 0 ? json.max : 1; // avoid division by zero

                    // Build bars
                    json.data.forEach(point => {
                        const h = Math.round((point.value / max) * chartHeight);

                        const wrap = document.createElement('div');
                        wrap.className = 'flex flex-col items-center space-y-2';

                        const bar = document.createElement('div');
                        bar.className = 'w-8 bg-blue-500 rounded-t';
                        bar.style.height = `${h}px`;
                        bar.title = `$${point.value.toFixed(2)} on ${point.label}`;

                        const label = document.createElement('span');
                        label.className = 'text-xs text-gray-500';
                        label.textContent = point.label;

                        wrap.appendChild(bar);
                        wrap.appendChild(label);
                        chartEl.appendChild(wrap);
                    });
                } catch (e) {
                    chartEl.innerHTML = '<div class="text-gray-500">Failed to load sales data.</div>';
                    console.error(e);
                }
            }

            // Initial + on change
            loadSales(parseInt(rangeEl.value, 10));
            rangeEl.addEventListener('change', (e) => loadSales(parseInt(e.target.value, 10)));
        })();
    </script>
</x-base>