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
                            <!-- Sample Data Row 1 -->
                            <tr class="hover:bg-green-50 transition-colors duration-200">
                                <td class="py-4 px-6 text-sm font-medium text-gray-900">1</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-receipt text-green-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900">INV-2024-001</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-user text-green-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900">John Smith</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-700">+1 234 567 8900</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-700">123 Garden St, Plant City</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-seedling mr-1"></i>
                                        3 Plants
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right text-sm font-semibold text-gray-900">$245.50</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$15.00</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$10.00</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$200.00</td>
                                <td class="py-4 px-6 text-right">
                                    <span class="text-sm font-medium text-amber-600">$50.50</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center space-x-1">
                                        <!-- Added print button to action buttons -->
                                        <button onclick="printInvoice(1)" class="px-2 py-1.5 bg-green-500 text-white text-xs rounded-md hover:bg-green-600 transition-colors duration-200" title="Print Invoice">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button onclick="viewSale(1)" class="px-2 py-1.5 bg-blue-500 text-white text-xs rounded-md hover:bg-blue-600 transition-colors duration-200" title="View Sale">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="editSale(1)" class="px-2 py-1.5 bg-amber-500 text-white text-xs rounded-md hover:bg-amber-600 transition-colors duration-200" title="Edit Sale">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteSale(1)" class="px-2 py-1.5 bg-red-500 text-white text-xs rounded-md hover:bg-red-600 transition-colors duration-200" title="Delete Sale">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Sample Data Row 2 -->
                            <tr class="hover:bg-green-50 transition-colors duration-200">
                                <td class="py-4 px-6 text-sm font-medium text-gray-900">2</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-receipt text-green-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900">INV-2024-002</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-user text-green-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900">Sarah Johnson</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-700">+1 234 567 8901</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-700">456 Bloom Ave, Green Valley</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-seedling mr-1"></i>
                                        5 Plants
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right text-sm font-semibold text-gray-900">$380.00</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$20.00</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$25.00</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$380.00</td>
                                <td class="py-4 px-6 text-right">
                                    <span class="text-sm font-medium text-green-600">$0.00</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center space-x-1">
                                        <!-- Added print button to action buttons -->
                                        <button onclick="printInvoice(2)" class="px-2 py-1.5 bg-green-500 text-white text-xs rounded-md hover:bg-green-600 transition-colors duration-200" title="Print Invoice">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button onclick="viewSale(2)" class="px-2 py-1.5 bg-blue-500 text-white text-xs rounded-md hover:bg-blue-600 transition-colors duration-200" title="View Sale">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="editSale(2)" class="px-2 py-1.5 bg-amber-500 text-white text-xs rounded-md hover:bg-amber-600 transition-colors duration-200" title="Edit Sale">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteSale(2)" class="px-2 py-1.5 bg-red-500 text-white text-xs rounded-md hover:bg-red-600 transition-colors duration-200" title="Delete Sale">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Sample Data Row 3 -->
                            <tr class="hover:bg-green-50 transition-colors duration-200">
                                <td class="py-4 px-6 text-sm font-medium text-gray-900">3</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-receipt text-green-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900">INV-2024-003</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-user text-green-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900">Mike Wilson</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-700">+1 234 567 8902</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-700">789 Leaf Lane, Forest Hills</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-seedling mr-1"></i>
                                        2 Plants
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right text-sm font-semibold text-gray-900">$150.75</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$10.00</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$5.00</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$100.00</td>
                                <td class="py-4 px-6 text-right">
                                    <span class="text-sm font-medium text-amber-600">$55.75</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center space-x-1">
                                        <!-- Added print button to action buttons -->
                                        <button onclick="printInvoice(3)" class="px-2 py-1.5 bg-green-500 text-white text-xs rounded-md hover:bg-green-600 transition-colors duration-200" title="Print Invoice">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button onclick="viewSale(3)" class="px-2 py-1.5 bg-blue-500 text-white text-xs rounded-md hover:bg-blue-600 transition-colors duration-200" title="View Sale">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="editSale(3)" class="px-2 py-1.5 bg-amber-500 text-white text-xs rounded-md hover:bg-amber-600 transition-colors duration-200" title="Edit Sale">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteSale(3)" class="px-2 py-1.5 bg-red-500 text-white text-xs rounded-md hover:bg-red-600 transition-colors duration-200" title="Delete Sale">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Sample Data Row 4 -->
                            <tr class="hover:bg-green-50 transition-colors duration-200">
                                <td class="py-4 px-6 text-sm font-medium text-gray-900">4</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-receipt text-green-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900">INV-2024-004</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-user text-green-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900">Emily Davis</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-700">+1 234 567 8903</span>
                                    </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-700">321 Fern Road, Botanical Gardens</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-seedling mr-1"></i>
                                        7 Plants
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right text-sm font-semibold text-gray-900">$520.25</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$25.00</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$30.00</td>
                                <td class="py-4 px-6 text-right text-sm text-gray-700">$300.00</td>
                                <td class="py-4 px-6 text-right">
                                    <span class="text-sm font-medium text-amber-600">$215.25</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center space-x-1">
                                        <!-- Added print button to action buttons -->
                                        <button onclick="printInvoice(4)" class="px-2 py-1.5 bg-green-500 text-white text-xs rounded-md hover:bg-green-600 transition-colors duration-200" title="Print Invoice">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button onclick="viewSale(4)" class="px-2 py-1.5 bg-blue-500 text-white text-xs rounded-md hover:bg-blue-600 transition-colors duration-200" title="View Sale">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="editSale(4)" class="px-2 py-1.5 bg-amber-500 text-white text-xs rounded-md hover:bg-amber-600 transition-colors duration-200" title="Edit Sale">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteSale(4)" class="px-2 py-1.5 bg-red-500 text-white text-xs rounded-md hover:bg-red-600 transition-colors duration-200" title="Delete Sale">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer with Summary -->
                <div class="px-6 py-4 bg-green-50 border-t border-green-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-green-700">
                            Showing <span class="font-medium">4</span> sales records
                        </div>
                        <div class="flex items-center space-x-6 text-sm">
                            <div class="text-green-700">
                                Total Sales: <span class="font-semibold text-green-800">$1,296.50</span>
                            </div>
                            <div class="text-green-700">
                                Outstanding Balance: <span class="font-semibold text-amber-600">$321.50</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printInvoice(saleId) {
            // Sample data - in real application, this would come from your backend
            const salesData = {
                1: {
                    invoice: 'INV-2024-001',
                    date: '03-06-2025',
                    customer: 'John Smith',
                    phone: '+1 234 567 8900',
                    address: '123 Garden St, Plant City',
                    products: [
                        { name: 'Medium Snake Plants', qty: 6, price: 5.00, total: 30.00 },
                        { name: 'Mini Snake Plants', qty: 14, price: 3.00, total: 42.00 },
                        { name: 'Plantation Service', qty: 1, price: 25.00, total: 25.00 }
                    ],
                    subtotal: 97.00,
                    delivery: 15.00,
                    discount: 10.00,
                    total: 245.50,
                    paid: 200.00,
                    balance: 50.50
                },
                2: {
                    invoice: 'INV-2024-002',
                    date: '04-06-2025',
                    customer: 'Sarah Johnson',
                    phone: '+1 234 567 8901',
                    address: '456 Bloom Ave, Green Valley',
                    products: [
                        { name: 'Large Monstera Plants', qty: 3, price: 45.00, total: 135.00 },
                        { name: 'Pothos Collection', qty: 8, price: 12.00, total: 96.00 },
                        { name: 'Plant Care Kit', qty: 2, price: 15.00, total: 30.00 },
                        { name: 'Fertilizer Package', qty: 1, price: 25.00, total: 25.00 }
                    ],
                    subtotal: 286.00,
                    delivery: 20.00,
                    discount: 25.00,
                    total: 380.00,
                    paid: 380.00,
                    balance: 0.00
                },
                3: {
                    invoice: 'INV-2024-003',
                    date: '05-06-2025',
                    customer: 'Mike Wilson',
                    phone: '+1 234 567 8902',
                    address: '789 Leaf Lane, Forest Hills',
                    products: [
                        { name: 'Rubber Plant Large', qty: 1, price: 65.00, total: 65.00 },
                        { name: 'Peace Lily Medium', qty: 2, price: 25.00, total: 50.00 }
                    ],
                    subtotal: 115.00,
                    delivery: 10.00,
                    discount: 5.00,
                    total: 150.75,
                    paid: 100.00,
                    balance: 55.75
                },
                4: {
                    invoice: 'INV-2024-004',
                    date: '06-06-2025',
                    customer: 'Emily Davis',
                    phone: '+1 234 567 8903',
                    address: '321 Fern Road, Botanical Gardens',
                    products: [
                        { name: 'Fiddle Leaf Fig', qty: 2, price: 85.00, total: 170.00 },
                        { name: 'Snake Plant Collection', qty: 5, price: 18.00, total: 90.00 },
                        { name: 'Succulent Garden Kit', qty: 3, price: 22.00, total: 66.00 },
                        { name: 'Plant Stand Set', qty: 1, price: 45.00, total: 45.00 },
                        { name: 'Watering System', qty: 1, price: 35.00, total: 35.00 }
                    ],
                    subtotal: 406.00,
                    delivery: 25.00,
                    discount: 30.00,
                    total: 520.25,
                    paid: 300.00,
                    balance: 215.25
                }
            };

            const sale = salesData[saleId];
            if (!sale) {
                Swal.fire('Error', 'Sale data not found', 'error');
                return;
            }

            generatePDF(sale);
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
            
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(28);
            doc.setFont('helvetica', 'bold');
            doc.text('Geedsoor', 20, 20);
            
            doc.setFontSize(11);
            doc.setFont('helvetica', 'normal');
            doc.text('Premium Plant Solutions & Garden Services', 20, 27);

            // Company contact info
            doc.setTextColor(...black);
            doc.setFontSize(10);
            doc.text('Taleex-Hodan, Mogadishu Somalia', 20, 45);
            doc.text('Phone: +252 611141415', 20, 52);
            doc.text('Email: info@geedsoor.com', 20, 59);

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
            const summaryStartY = yPos;
            
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
            doc.text('Thank you for choosing Geedsoor - Growing green dreams together!', 25, yPos);
            doc.text('For support: info@geedsoor.com | +252 611141415', 25, yPos + 7);

            // Decorative plant icons (using text symbols)
            doc.setTextColor(...primaryGreen);
            doc.setFontSize(12);
            doc.text('🌱', 15, 20);
            doc.text('🌿', 195, 20);
            doc.text('🌱', 15, yPos + 10);
            doc.text('🌿', 195, yPos + 10);

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

        function viewSale(saleId) {
            // Redirect to view page
            window.location.href = `/admin/sales/${saleId}/view`;
        }

        function editSale(saleId) {
            // Redirect to edit page with pre-filled data
            window.location.href = `/admin/sales/${saleId}/edit`;
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
                    // Here you would make an AJAX call to delete the sale
                    // For demo purposes, we'll show a success message
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
