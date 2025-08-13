<x-base>
    <x-slot name="page_title">{{ $page_title }}</x-slot>
    
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
                            <i class="fas fa-eye mr-3 text-green-600"></i>
                            Sale Details
                        </h1>
                        <p class="text-green-600">View complete sale transaction information</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="printInvoice({{ $sale->sale_id }})" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors duration-200">
                            <i class="fas fa-print mr-2"></i>Print Invoice
                        </button>
                        <a href="{{ route('admin.sales.edit_sale_view', $sale->sale_id) }}" class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>Edit Sale
                        </a>
                        <button onclick="window.history.back()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sale Information Display -->
            <div class="space-y-6">
                
                <!-- Sale Header Info -->
                <div class="bg-white rounded-md shadow-sm border border-green-200 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-receipt text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-green-800">Invoice Number</h3>
                            <p class="text-gray-600">{{$sale->invoice_number}}</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-calendar text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-green-800">Sale Date</h3>
                            <p class="text-gray-600">{{ $sale->sales_date }}</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-dollar-sign text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-green-800">Total Amount</h3>
                            <p class="text-gray-600 text-xl font-bold">${{ $sale->grand_total }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Information Section -->
                <div class="bg-white rounded-md shadow-sm border border-green-200 p-6">
                    <h2 class="text-xl font-semibold text-green-800 mb-4 flex items-center">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Customer Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Customer Name</label>
                            <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-md text-gray-800">
                                {{ $sale->customer_name }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Customer Number</label>
                            <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-md text-gray-800">
                                {{ $sale->customer_number }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Customer Address</label>
                            <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-md text-gray-800">
                                {{ $sale->customer_address }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="bg-white rounded-md shadow-sm border border-green-200 p-6">
                    <h2 class="text-xl font-semibold text-green-800 mb-4 flex items-center">
                        <i class="fas fa-leaf mr-2 text-green-600"></i>
                        Plant Products Purchased
                    </h2>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-green-100 border-b border-green-200">
                                    <th class="text-left py-3 px-4 font-semibold text-green-800">Product</th>
                                    <th class="text-center py-3 px-4 font-semibold text-green-800">Qty</th>
                                    <th class="text-right py-3 px-4 font-semibold text-green-800">Unit Price</th>
                                    <th class="text-right py-3 px-4 font-semibold text-green-800">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selected_products as $product)
                                    <tr class="border-b border-green-100 hover:bg-green-50">
                                        <td class="py-4 px-4">
                                            <div class="flex items-center">
                                                <i class="fas fa-seedling text-green-600 mr-3"></i>
                                                <span class="font-medium text-gray-800">{{ $product->product_name}}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $product->quantity }} units
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-right font-medium text-gray-800">${{ $product->price}}</td>
                                        <td class="py-4 px-4 text-right font-semibold text-green-800">${{ $product->quantity * $product->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-green-200 text-right">
                        <span class="text-lg font-semibold text-green-800">
                            Subtotal: ${{ $selected_products->sum(function($product) { return $product->quantity * $product->price; }) }}
                        </span>
                    </div>
                </div>

                <!-- Financial Details Section -->
                <div class="bg-white rounded-md shadow-sm border border-green-200 p-6">
                    <h2 class="text-xl font-semibold text-green-800 mb-4 flex items-center">
                        <i class="fas fa-calculator mr-2 text-green-600"></i>
                        Financial Summary
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="bg-blue-100 rounded-md p-4">
                                <i class="fas fa-percentage text-blue-600 text-2xl mb-2"></i>
                                <h3 class="text-sm font-medium text-blue-700 mb-1">Discount</h3>
                                <p class="text-xl font-bold text-blue-800">${{ $sale->discount }}</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="bg-amber-100 rounded-md p-4">
                                <i class="fas fa-truck text-amber-600 text-2xl mb-2"></i>
                                <h3 class="text-sm font-medium text-amber-700 mb-1">Delivery</h3>
                                <p class="text-xl font-bold text-amber-800">${{ $sale->delivery }}</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="bg-green-100 rounded-md p-4">
                                <i class="fas fa-check-circle text-green-600 text-2xl mb-2"></i>
                                <h3 class="text-sm font-medium text-green-700 mb-1">Paid</h3>
                                <p class="text-xl font-bold text-green-800">${{ $sale->paid }}</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="bg-red-100 rounded-md p-4">
                                <i class="fas fa-exclamation-circle text-red-600 text-2xl mb-2"></i>
                                <h3 class="text-sm font-medium text-red-700 mb-1">Balance</h3>
                                <p class="text-xl font-bold text-red-800">${{ $sale->balance }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-green-200">
                        <div class="bg-green-100 rounded-md p-6 text-center">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">Grand Total</h3>
                            <p class="text-3xl font-bold text-green-800">${{ $sale->grand_total }}</p>
                            <div class="mt-3 flex items-center justify-center">
                                @if($sale->balance > 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Outstanding Balance: ${{ $sale->balance }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Fully Paid
                                    </span>
                                @endif
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


        // Add keyboard shortcuts for common actions
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'p':
                        e.preventDefault();
                        printInvoice({{ $sale->sale_id }});
                        break;
                    case 'e':
                        e.preventDefault();
                        window.location.href = `{{ route('admin.sales.edit_sale_view',':id') }}`.replace(':id', {{ $sale->sale_id }});
                        break;
                }
            }
            if (e.key === 'Escape') {
                window.history.back();
            }
        });

        // Add smooth animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.bg-white');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    section.style.transition = 'all 0.5s ease';
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</x-base>
