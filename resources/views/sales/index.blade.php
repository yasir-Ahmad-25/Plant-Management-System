<x-base>
    <x-slot name="page_title">Sales Management - Plant Products</x-slot>
    
    <!-- Required CDN links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Added jsPDF library for PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    <div class="bg-green-50 min-h-screen -m-4 p-4">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div> 
                        <h1 class="text-3xl font-bold text-green-800 mb-2">
                            <i class="fas fa-chart-line mr-3 text-green-600"></i>
                            Sales Management
                        </h1>
                        <p class="text-green-600">Manage all plant product sales and transactions</p>
                    </div>
                    <div class="flex justify-end">
                        <a href="{{ route('admin.sales.create_sale_view')}}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 bg-green-500 hover:bg-green-600 text-white shadow-sm">
                            <i class="fa-solid fa-seedling mr-3"></i>
                            Add New Sales
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sales Table -->
            <div class="bg-white rounded-md shadow-sm border border-green-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-green-200 bg-green-50">
                    <h2 class="text-xl font-semibold text-green-800 flex items-center">
                        <i class="fas fa-table mr-2 text-green-600"></i>
                        Sales Records
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-green-100 border-b border-green-200">
                            <tr>
                                <th class="text-left py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">#</th>
                                <th class="text-left py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Sale Invoice</th>
                                <th class="text-left py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Customer</th>
                                <th class="text-left py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Phone</th>
                                <th class="text-left py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Address</th>
                                <th class="text-center py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">No Of Products</th>
                                <th class="text-right py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Total</th>
                                <th class="text-right py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Delivery</th>
                                <th class="text-right py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Discount</th>
                                <th class="text-right py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Paid</th>
                                <th class="text-right py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Balance</th>
                                <th class="text-center py-4 px-6 font-semibold text-green-800 text-sm uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-green-100">
                            @foreach ($sales as $sale)
                                <tr class="hover:bg-green-50 transition-colors duration-200">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900">1</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <i class="fas fa-receipt text-green-600 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-900">{{ $sale->invoice_number}} </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <i class="fas fa-user text-green-600 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-900">{{ $sale->customer_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-green-600 mr-2"></i>
                                            <span class="text-sm text-gray-700">{{ $sale->customer_number}}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                                            <span class="text-sm text-gray-700">{{ $sale->customer_address}}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-seedling mr-1"></i>
                                            {{ $sale->number_of_products}} Plants
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right text-sm font-semibold text-gray-900">${{ $sale->grand_total ?? 0}}</td>
                                    <td class="py-4 px-6 text-right text-sm text-gray-700">${{ $sale->delivery}}</td>
                                    <td class="py-4 px-6 text-right text-sm text-gray-700">${{ $sale->discount}}</td>
                                    <td class="py-4 px-6 text-right text-sm text-gray-700">${{ $sale->paid }}</td>
                                    <td class="py-4 px-6 text-right">
                                        <span class="text-sm font-medium text-amber-600">$ {{ $sale->balance }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center space-x-1">
                                            <!-- Added print button to action buttons -->
                                            <button onclick="printInvoice({{ $sale->sale_id }})" class="px-2 py-1.5 bg-green-500 text-white text-xs rounded-md hover:bg-green-600 transition-colors duration-200" title="Print Invoice">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <button onclick="viewSale({{ $sale->sale_id }})" class="px-2 py-1.5 bg-blue-500 text-white text-xs rounded-md hover:bg-blue-600 transition-colors duration-200" title="View Sale">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="editSale({{ $sale->sale_id }})" class="px-2 py-1.5 bg-amber-500 text-white text-xs rounded-md hover:bg-amber-600 transition-colors duration-200" title="Edit Sale">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteSale({{ $sale->sale_id }})" class="px-2 py-1.5 bg-red-500 text-white text-xs rounded-md hover:bg-red-600 transition-colors duration-200" title="Delete Sale">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer with Summary -->
                <div class="px-6 py-4 bg-green-50 border-t border-green-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-green-700">
                            Showing <span class="font-medium">{{ number_format($sales->count())}}</span> sales records
                        </div>
                        <div class="flex items-center space-x-6 text-sm">
                            <div class="text-green-700">
                                Total Sales: <span class="font-semibold text-green-800">${{ number_format($sales->sum('grand_total'), 2) }}</span>
                            </div>
                            <div class="text-green-700">
                                Outstanding Balance: <span class="font-semibold text-amber-600">${{ number_format($sales->sum('balance'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function printInvoice(saleId) {
            $.ajax({
                url: `{{ route('admin.sales.get_sale_data', ':id') }}`.replace(':id', saleId),
                type: 'GET',
                success: function(response) {
                    if (response.status) {
                        console.log('Sale data fetched successfully:', response.products);
                        const responseSalesData = {
                                invoice: response.sale.invoice_number,
                                date: response.sale.sales_date,
                                customer: response.sale.customer_name,
                                phone: response.sale.customer_number,
                                address: response.sale.customer_address,
                                products: Array.isArray(response.products) ? response.products.map(product => ({
                                        name: product.product_name,
                                        qty: product.quantity,
                                        price: product.price,
                                        total: product.total
                                    })) : [],

                                // Calculate subtotal by summing product totals
                                subtotal: Array.isArray(response.products) ? response.products.reduce((sum, product) => sum + Number(product.total), 0) : 0,
                                delivery: response.sale.delivery ?? 0,
                                discount: response.sale.discount ?? 0,
                                total: response.sale.grand_total ?? 0,
                                paid: response.sale.paid ?? 0,
                                balance: response.sale.balance ?? 0
                        };
                        
                        console.log('Sales data for PDF:', responseSalesData);
                        // const sale = responseSalesData[saleId];
                        if (!responseSalesData) {
                            Swal.fire('Error', 'Sale data not found', 'error');
                            return;
                        }
                        generatePDF(responseSalesData);
                    } else {
                        Swal.fire('Error', 'Sale data not found', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'There was an error fetching the sale data. Please try again.', 'error');
                }
            });
        }

        // function generatePDF(saleData) {
        //     const { jsPDF } = window.jspdf;
        //     const doc = new jsPDF();

        //     // Set up colors
        //     const primaryGreen = [34, 139, 34];
        //     const darkGreen = [0, 100, 0];
        //     const lightGray = [128, 128, 128];
        //     const black = [0, 0, 0];

        //     // Company Header with enhanced styling
        //     doc.setFillColor(...primaryGreen);
        //     doc.rect(0, 0, 210, 35, 'F');
            
        //     doc.setTextColor(255, 255, 255);
        //     doc.setFontSize(28);
        //     doc.setFont('helvetica', 'bold');
        //     doc.text('Planter', 20, 20);
            
        //     doc.setFontSize(11);
        //     doc.setFont('helvetica', 'normal');
        //     doc.text('Premium Plant Solutions & Garden Services', 20, 27);

        //     // Company contact info
        //     doc.setTextColor(...black);
        //     doc.setFontSize(10);
        //     doc.text('Taleex-Hodan, Mogadishu Somalia', 20, 45);
        //     doc.text('Phone: +252 61XXXXXXX', 20, 52);
        //     doc.text('Email: info@Planter.com', 20, 59);

        //     // Invoice title and details box
        //     doc.setFillColor(248, 250, 252);
        //     doc.rect(120, 40, 70, 35, 'F');
        //     doc.setDrawColor(...primaryGreen);
        //     doc.rect(120, 40, 70, 35, 'S');

        //     doc.setTextColor(...darkGreen);
        //     doc.setFontSize(18);
        //     doc.setFont('helvetica', 'bold');
        //     doc.text('INVOICE', 135, 50);

        //     doc.setFontSize(10);
        //     doc.setFont('helvetica', 'normal');
        //     doc.text(`DATE: ${saleData.date}`, 125, 60);
        //     doc.text(`INVOICE NO: ${saleData.invoice}`, 125, 68);

        //     // Bill To section with enhanced styling
        //     doc.setFillColor(...primaryGreen);
        //     doc.rect(20, 85, 170, 8, 'F');
        //     doc.setTextColor(255, 255, 255);
        //     doc.setFontSize(12);
        //     doc.setFont('helvetica', 'bold');
        //     doc.text('BILL TO', 25, 91);

        //     doc.setTextColor(...black);
        //     doc.setFontSize(11);
        //     doc.setFont('helvetica', 'bold');
        //     doc.text(saleData.customer, 25, 105);
        //     doc.setFont('helvetica', 'normal');
        //     doc.setFontSize(10);
        //     doc.text(saleData.address, 25, 112);
        //     doc.text(saleData.phone, 25, 119);

        //     // Products table with enhanced design
        //     let yPos = 140;
            
        //     // Table header
        //     doc.setFillColor(...primaryGreen);
        //     doc.rect(20, yPos, 170, 10, 'F');
        //     doc.setTextColor(255, 255, 255);
        //     doc.setFontSize(10);
        //     doc.setFont('helvetica', 'bold');
        //     doc.text('DESCRIPTION', 25, yPos + 7);
        //     doc.text('QTY', 120, yPos + 7);
        //     doc.text('UNIT PRICE', 140, yPos + 7);
        //     doc.text('TOTAL', 170, yPos + 7);

        //     yPos += 10;

        //     // Table rows with alternating colors
        //     doc.setTextColor(...black);
        //     doc.setFont('helvetica', 'normal');
        //     saleData.products.forEach((product, index) => {
        //         console.log(`Product: ${product.name}, Qty: ${product.qty}, Price: ${product.price}, Total: ${product.total}`);
        //         if (index % 2 === 0) {
        //             doc.setFillColor(248, 250, 252);
        //             doc.rect(20, yPos, 170, 8, 'F');
        //         }
                
        //         doc.text(product.name, 25, yPos + 6);
        //         doc.text(product.qty.toString(), 125, yPos + 6);
        //         doc.text(`$${product.price.toFixed(2)}`, 145, yPos + 6);
        //         doc.text(`$${product.total.toFixed(2)}`, 175, yPos + 6);
        //         yPos += 8;
        //     });

        //     // Summary section with enhanced styling
        //     yPos += 10;
        //     const summaryStartY = yPos;
            
        //     // Summary box
        //     doc.setFillColor(248, 250, 252);
        //     doc.rect(120, yPos, 70, 35, 'F');
        //     doc.setDrawColor(...primaryGreen);
        //     doc.rect(120, yPos, 70, 35, 'S');

        //     doc.setFontSize(10);
        //     doc.text('SUBTOTAL:', 125, yPos + 8);
        //     doc.text(`$${saleData.subtotal.toFixed(2)}`, 175, yPos + 8);

        //     doc.text('SHIPPING/HANDLING:', 125, yPos + 15);
        //     doc.text(`$${saleData.delivery.toFixed(2)}`, 175, yPos + 15);

        //     doc.text('DISCOUNT:', 125, yPos + 22);
        //     doc.text(`-$${saleData.discount.toFixed(2)}`, 175, yPos + 22);

        //     // Balance Due with emphasis
        //     doc.setFillColor(...primaryGreen);
        //     doc.rect(120, yPos + 25, 70, 10, 'F');
        //     doc.setTextColor(255, 255, 255);
        //     doc.setFont('helvetica', 'bold');
        //     doc.text('BALANCE DUE:', 125, yPos + 32);
        //     doc.text(`$${saleData.balance.toFixed(2)}`, 175, yPos + 32);

        //     // Payment information
        //     yPos += 45;
        //     doc.setTextColor(...black);
        //     doc.setFont('helvetica', 'normal');
        //     doc.setFontSize(9);
        //     doc.text(`Total Amount: $${saleData.total.toFixed(2)}`, 25, yPos);
        //     doc.text(`Amount Paid: $${saleData.paid.toFixed(2)}`, 25, yPos + 7);
        //     doc.text(`Outstanding Balance: $${saleData.balance.toFixed(2)}`, 25, yPos + 14);

        //     // Footer with plant-themed message
        //     yPos += 30;
        //     doc.setTextColor(...lightGray);
        //     doc.setFontSize(8);
        //     doc.text('Thank you for choosing Planter - Growing green dreams together!', 25, yPos);
        //     doc.text('For support: info@Planter.com | +252 61XXXXXXX', 25, yPos + 7);

        //     // Decorative plant icons (using text symbols)
        //     doc.setTextColor(...primaryGreen);
        //     doc.setFontSize(12);
        //     doc.text('🌱', 15, 20);
        //     doc.text('🌿', 195, 20);
        //     doc.text('🌱', 15, yPos + 10);
        //     doc.text('🌿', 195, yPos + 10);

        //     // Save the PDF
        //     doc.save(`Invoice-${saleData.invoice}.pdf`);

        //     // Show success message
        //     Swal.fire({
        //         title: 'Invoice Generated!',
        //         text: `Invoice ${saleData.invoice} has been generated successfully.`,
        //         icon: 'success',
        //         confirmButtonColor: '#16a34a',
        //         timer: 2000,
        //         timerProgressBar: true
        //     });
        // }

        function generatePDF(saleData) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Set up colors
            const primaryGreen = [34, 139, 34];
            const darkGreen = [0, 100, 0];
            const lightGray = [128, 128, 128];
            const black = [0, 0, 0];

            // Company Header with enhanced styling
            doc.setFillColor(...primaryGreen);
            doc.rect(0, 0, 210, 35, 'F');
            
            // <CHANGE> Added rounded logo before company name
            // Create a rounded logo/icon
            doc.setFillColor(255, 255, 255);
            doc.circle(30, 20, 8, 'F'); // White circle background
            doc.setFillColor(...darkGreen);
            doc.circle(30, 20, 6, 'F'); // Green inner circle
            
            // const img = await loadImage('{{asset('images/Logo.png')}}'); // e.g. public path or full URL
            loadImage(`{{ asset('images/Logo.png') }}`).then(img => {
                const logoSize = 12;
                const logoX = 24;
                const logoY = 14;
                doc.addImage(img, 'png', logoX, logoY, logoSize, logoSize);
            });
            
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(28);
            doc.setFont('helvetica', 'bold');
            doc.text('Planter', 45, 20); // Moved text to make room for logo
            
            doc.setFontSize(11);
            doc.setFont('helvetica', 'normal');
            doc.text('Premium Plant Solutions & Garden Services', 45, 27);

            // Company contact info
            doc.setTextColor(...black);
            doc.setFontSize(10);
            doc.text('Taleex-Hodan, Mogadishu Somalia', 20, 45);
            doc.text('Phone: +252 61XXXXXXX', 20, 52);
            doc.text('Email: info@Planter.com', 20, 59);

            // Invoice title and details box
            doc.setFillColor(248, 250, 252);
            doc.rect(120, 40, 70, 35, 'F');
            doc.setDrawColor(...primaryGreen);
            doc.rect(120, 40, 70, 35, 'S');

            doc.setTextColor(...darkGreen);
            doc.setFontSize(18);
            doc.setFont('helvetica', 'bold');
            doc.text('INVOICE', 135, 50);

            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            doc.text(`DATE: ${saleData.date}`, 125, 60);
            doc.text(`INVOICE NO: ${saleData.invoice}`, 125, 68);

            // Bill To section with enhanced styling
            doc.setFillColor(...primaryGreen);
            doc.rect(20, 85, 170, 8, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(12);
            doc.setFont('helvetica', 'bold');
            doc.text('BILL TO', 25, 91);

            doc.setTextColor(...black);
            doc.setFontSize(11);
            doc.setFont('helvetica', 'bold');
            doc.text(saleData.customer, 25, 105);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text(saleData.address, 25, 112);
            doc.text(saleData.phone, 25, 119);

            // Products table with enhanced design
            let yPos = 140;
            
            // Table header
            doc.setFillColor(...primaryGreen);
            doc.rect(20, yPos, 170, 10, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(10);
            doc.setFont('helvetica', 'bold');
            doc.text('DESCRIPTION', 25, yPos + 7);
            doc.text('QTY', 120, yPos + 7);
            doc.text('UNIT PRICE', 140, yPos + 7);
            doc.text('TOTAL', 170, yPos + 7);

            yPos += 10;

            // Table rows with alternating colors
            doc.setTextColor(...black);
            doc.setFont('helvetica', 'normal');
            saleData.products.forEach((product, index) => {
                if (index % 2 === 0) {
                    doc.setFillColor(248, 250, 252);
                    doc.rect(20, yPos, 170, 8, 'F');
                }
                
                doc.text(product.name, 25, yPos + 6);
                doc.text(product.qty.toString(), 125, yPos + 6);
                doc.text(`$${product.price.toFixed(2)}`, 145, yPos + 6);
                doc.text(`$${product.total.toFixed(2)}`, 175, yPos + 6);
                yPos += 8;
            });

            // Summary section with enhanced styling
            yPos += 10;
            
            // Summary box
            doc.setFillColor(248, 250, 252);
            doc.rect(120, yPos, 70, 35, 'F');
            doc.setDrawColor(...primaryGreen);
            doc.rect(120, yPos, 70, 35, 'S');

            doc.setFontSize(10);
            doc.text('SUBTOTAL:', 125, yPos + 8);
            doc.text(`$${saleData.subtotal.toFixed(2)}`, 175, yPos + 8);

            doc.text('SHIPPING/HANDLING:', 125, yPos + 15);
            doc.text(`$${saleData.delivery.toFixed(2)}`, 175, yPos + 15);

            doc.text('DISCOUNT:', 125, yPos + 22);
            doc.text(`-$${saleData.discount.toFixed(2)}`, 175, yPos + 22);

            // Balance Due with emphasis
            doc.setFillColor(...primaryGreen);
            doc.rect(120, yPos + 25, 70, 10, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.text('BALANCE DUE:', 125, yPos + 32);
            doc.text(`$${saleData.balance.toFixed(2)}`, 175, yPos + 32);

            // Payment information
            yPos += 45;
            doc.setTextColor(...black);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.text(`Total Amount: $${saleData.total.toFixed(2)}`, 25, yPos);
            doc.text(`Amount Paid: $${saleData.paid.toFixed(2)}`, 25, yPos + 7);
            doc.text(`Outstanding Balance: $${saleData.balance.toFixed(2)}`, 25, yPos + 14);

            // Footer with plant-themed message
            yPos += 30;
            doc.setTextColor(...lightGray);
            doc.setFontSize(8);
            doc.text('Thank you for choosing Planter - Growing green dreams together!', 25, yPos);
            doc.text('For support: info@Planter.com | +252 61XXXXXXX', 25, yPos + 7);

            // <CHANGE> Replaced problematic emoji symbols with simple geometric decorations
            // Simple decorative elements using supported characters
            doc.setTextColor(...primaryGreen);
            doc.setFontSize(8);
            doc.text('*', 15, 20);
            doc.text('*', 195, 20);
            doc.text('*', 15, yPos + 10);
            doc.text('*', 195, yPos + 10);

            // Save the PDF
            doc.save(`Invoice-${saleData.invoice}.pdf`);

            // Show success message
            Swal.fire({
                title: 'Invoice Generated!',
                text: `Invoice ${saleData.invoice} has been generated successfully.`,
                icon: 'success',
                confirmButtonColor: '#16a34a',
                timer: 2000,
                timerProgressBar: true
            });
        }

        function loadImage(url) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = url;
            });
        }

        function viewSale(saleId) {
            // Redirect to view page
            // window.location.href = `/admin/sales/${saleId}/view`;
            window.location.href = `{{ route('admin.sales.view',':id') }}`.replace(':id', saleId);
        }

        function editSale(saleId) {
            // Redirect to edit page with pre-filled data
            // window.location.href = `/admin/sales/${saleId}/edit`;
            window.location.href = `{{ route('admin.sales.edit_sale_view',':id') }}`.replace(':id',saleId);
        }

        function deleteSale(saleId) {
            Swal.fire({
                title: 'Delete Sale Record?',
                text: 'Are you sure you want to delete this sale? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#16a34a',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: `{{ route('admin.sales.delete',':id')}}`.replace(':id', saleId),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Handle success response
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The sale record has been successfully deleted.',
                                icon: 'success',
                                confirmButtonColor: '#16a34a',
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                // Remove the row from the table (for demo)
                                const row = document.querySelector(`tr:has(button[onclick="deleteSale(${saleId})"])`);
                                if (row) {
                                    row.style.transition = 'opacity 0.3s ease';
                                    row.style.opacity = '0';
                                    setTimeout(() => {
                                        row.remove();
                                        updateTableSummary();
                                    }, 300);
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an error deleting the sale record. Please try again.',
                                icon: 'error',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    })
                }
            });
        }

        function updateTableSummary() {
            // Update the summary counts after deletion
            const remainingRows = document.querySelectorAll('tbody tr').length;
            const summaryText = document.querySelector('.text-green-700 span');
            if (summaryText) {
                summaryText.textContent = remainingRows;
            }
        }

        // Add keyboard navigation for accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Close any open modals or dialogs
                Swal.close();
            }
        });

        // Initialize tooltips for action buttons
        document.addEventListener('DOMContentLoaded', function() {
            const actionButtons = document.querySelectorAll('button[onclick^="viewSale"], button[onclick^="editSale"], button[onclick^="deleteSale"], button[onclick^="printInvoice"]');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</x-base>
