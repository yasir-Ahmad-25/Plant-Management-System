<x-base>
    <x-slot name="page_title">Add New Sale - Plant Products</x-slot>
    
    <!-- Added required CDN links for functionality -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <div class="bg-green-50 min-h-screen -m-4 p-4">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-green-800 mb-2">
                            <i class="fas fa-seedling mr-3 text-green-600"></i>
                            New Plant Sale
                        </h1>
                        <p class="text-green-600">Add a new sale transaction for plant products</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="window.history.back()" class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sales Form -->
            <form id="salesForm" class="space-y-6">
                @csrf
                
                <!-- Customer Information Section -->
                <div class="bg-white rounded-md shadow-sm border border-green-200 p-6">
                    <h2 class="text-xl font-semibold text-green-800 mb-4 flex items-center">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Customer Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-green-700 mb-2">Customer Name</label>
                            <input type="text" id="customer_name" name="customer_name" required
                                   class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                   placeholder="Enter customer name">
                        </div>
                        <div>
                            <label for="customer_number" class="block text-sm font-medium text-green-700 mb-2">Customer Number</label>
                            <input type="text" id="customer_number" name="customer_number" required
                                   class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                   placeholder="Enter customer number">
                        </div>
                        <div>
                            <label for="customer_address" class="block text-sm font-medium text-green-700 mb-2">Customer Address</label>
                            <input type="text" id="customer_address" name="customer_address" required
                                   class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                   placeholder="Enter customer address">
                        </div>
                        <div>
                            <label for="sales_date" class="block text-sm font-medium text-green-700 mb-2">Sale Date</label>
                            <input type="date" id="sales_date" name="sales_date" required
                                   class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                   value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="bg-white rounded-md shadow-sm border border-green-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-green-800 flex items-center">
                            <i class="fas fa-leaf mr-2 text-green-600"></i>
                            Plant Products
                        </h2>
                        <button type="button" onclick="addProduct()" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors duration-200 flex items-center">
                            <i class="fas fa-plus mr-2"></i>Add Product
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-green-100 border-b border-green-200">
                                    <th class="text-left py-3 px-4 font-semibold text-green-800">Product</th>
                                    <th class="text-left py-3 px-4 font-semibold text-green-800">Qty</th>
                                    <th class="text-left py-3 px-4 font-semibold text-green-800">Price</th>
                                    <th class="text-left py-3 px-4 font-semibold text-green-800">Total</th>
                                    <th class="text-left py-3 px-4 font-semibold text-green-800">Action</th>
                                </tr>
                            </thead>
                            <tbody id="productTable">
                                <tr class="border-b border-green-100 product-row">
                                    <td class="py-3 px-4">
                                        <select name="products[0][product_id]" required
                                                class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                            <option value="">Select Plant</option>
                                            <option value="1">Monstera Deliciosa</option>
                                            <option value="2">Snake Plant</option>
                                            <option value="3">Fiddle Leaf Fig</option>
                                            <option value="4">Peace Lily</option>
                                            <option value="5">Rubber Plant</option>
                                        </select>
                                    </td>
                                    <td class="py-3 px-4">
                                        <input type="number" name="products[0][quantity]" min="1" value="1" required
                                               class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 quantity-input"
                                               onchange="calculateRowTotal(this)">
                                    </td>
                                    <td class="py-3 px-4">
                                        <input type="number" name="products[0][price]" step="0.01" min="0" required
                                               class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 price-input"
                                               onchange="calculateRowTotal(this)" placeholder="0.00">
                                    </td>
                                    <td class="py-3 px-4">
                                        <input type="number" name="products[0][total]" step="0.01" readonly
                                               class="w-full px-3 py-2 bg-green-50 border border-green-300 rounded-md total-input" placeholder="0.00">
                                    </td>
                                    <td class="py-3 px-4">
                                        <button type="button" onclick="removeProduct(this)" 
                                                class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-200">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 text-right">
                        <span class="text-lg font-semibold text-green-800">
                            Subtotal: $<span id="subtotal">0.00</span>
                        </span>
                    </div>
                </div>

                <!-- Financial Details Section -->
                <div class="bg-white rounded-md shadow-sm border border-green-200 p-6">
                    <h2 class="text-xl font-semibold text-green-800 mb-4 flex items-center">
                        <i class="fas fa-calculator mr-2 text-green-600"></i>
                        Financial Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label for="discount" class="block text-sm font-medium text-green-700 mb-2">Discount ($)</label>
                            <input type="number" id="discount" name="discount" step="0.01" min="0" value="0"
                                   class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                   onchange="calculateGrandTotal()" placeholder="0.00">
                        </div>
                        <div>
                            <label for="delivery" class="block text-sm font-medium text-green-700 mb-2">Delivery ($)</label>
                            <input type="number" id="delivery" name="delivery" step="0.01" min="0" value="0"
                                   class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                   onchange="calculateGrandTotal()" placeholder="0.00">
                        </div>
                        <div>
                            <label for="paid" class="block text-sm font-medium text-green-700 mb-2">Paid ($)</label>
                            <input type="number" id="paid" name="paid" step="0.01" min="0" value="0"
                                   class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                   onchange="calculateBalance()" placeholder="0.00">
                        </div>
                        <div>
                            <label for="balance" class="block text-sm font-medium text-green-700 mb-2">Balance ($)</label>
                            <input type="number" id="balance" name="balance" step="0.01" readonly
                                   class="w-full px-4 py-3 bg-green-50 border border-green-300 rounded-md" placeholder="0.00">
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-green-200">
                        <div class="text-right">
                            <span class="text-2xl font-bold text-green-800">
                                Grand Total: $<span id="grandTotal">0.00</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="cancelForm()" 
                            class="px-6 py-3 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>Save Sale
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let productIndex = 1;

        function addProduct() {
            const tableBody = document.getElementById('productTable');
            const newRow = document.createElement('tr');
            newRow.className = 'border-b border-green-100 product-row';
            newRow.innerHTML = `
                <td class="py-3 px-4">
                    <select name="products[${productIndex}][product_id]" required
                            class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Select Plant</option>
                        <option value="1">Monstera Deliciosa</option>
                        <option value="2">Snake Plant</option>
                        <option value="3">Fiddle Leaf Fig</option>
                        <option value="4">Peace Lily</option>
                        <option value="5">Rubber Plant</option>
                    </select>
                </td>
                <td class="py-3 px-4">
                    <input type="number" name="products[${productIndex}][quantity]" min="1" value="1" required
                           class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 quantity-input"
                           onchange="calculateRowTotal(this)">
                </td>
                <td class="py-3 px-4">
                    <input type="number" name="products[${productIndex}][price]" step="0.01" min="0" required
                           class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 price-input"
                           onchange="calculateRowTotal(this)" placeholder="0.00">
                </td>
                <td class="py-3 px-4">
                    <input type="number" name="products[${productIndex}][total]" step="0.01" readonly
                           class="w-full px-3 py-2 bg-green-50 border border-green-300 rounded-md total-input" placeholder="0.00">
                </td>
                <td class="py-3 px-4">
                    <button type="button" onclick="removeProduct(this)" 
                            class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-200">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(newRow);
            productIndex++;
        }

        function removeProduct(button) {
            const row = button.closest('tr');
            const tableBody = document.getElementById('productTable');
            
            if (tableBody.children.length > 1) {
                row.remove();
                calculateSubtotal();
                calculateGrandTotal();
                calculateBalance();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cannot Remove',
                    text: 'At least one product is required.',
                    confirmButtonColor: '#16a34a'
                });
            }
        }

        function calculateRowTotal(input) {
            const row = input.closest('tr');
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const total = quantity * price;
            
            row.querySelector('.total-input').value = total.toFixed(2);
            calculateSubtotal();
            calculateGrandTotal();
            calculateBalance();
        }

        function calculateSubtotal() {
            const totalInputs = document.querySelectorAll('.total-input');
            let subtotal = 0;
            
            totalInputs.forEach(input => {
                subtotal += parseFloat(input.value) || 0;
            });
            
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            return subtotal;
        }

        function calculateGrandTotal() {
            const subtotal = calculateSubtotal();
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const delivery = parseFloat(document.getElementById('delivery').value) || 0;
            
            const grandTotal = subtotal - discount + delivery;
            document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
            calculateBalance();
            return grandTotal;
        }

        function calculateBalance() {
            const grandTotal = parseFloat(document.getElementById('grandTotal').textContent) || 0;
            const paid = parseFloat(document.getElementById('paid').value) || 0;
            const balance = grandTotal - paid;
            
            document.getElementById('balance').value = balance.toFixed(2);
        }

        function cancelForm() {
            Swal.fire({
                title: 'Cancel Sale?',
                text: 'Are you sure you want to cancel? All entered data will be lost.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#16a34a',
                confirmButtonText: 'Yes, cancel',
                cancelButtonText: 'Continue editing'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        }

        document.getElementById('salesForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            const customerName = document.getElementById('customer_name').value.trim();
            const customerNumber = document.getElementById('customer_number').value.trim();
            const customerAddress = document.getElementById('customer_address').value.trim();
            
            if (!customerName || !customerNumber || !customerAddress) {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Information',
                    text: 'Please fill in all customer information fields.',
                    confirmButtonColor: '#16a34a'
                });
                return;
            }
            
            // Check if at least one product is added with valid data
            const productRows = document.querySelectorAll('.product-row');
            let hasValidProduct = false;
            
            productRows.forEach(row => {
                const productSelect = row.querySelector('select').value;
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                
                if (productSelect && quantity > 0 && price > 0) {
                    hasValidProduct = true;
                }
            });
            
            if (!hasValidProduct) {
                Swal.fire({
                    icon: 'error',
                    title: 'No Valid Products',
                    text: 'Please add at least one product with valid quantity and price.',
                    confirmButtonColor: '#16a34a'
                });
                return;
            }
            
            isSaved = sendAjaxRequest();
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Sale Saved!',
                text: 'The plant sale has been successfully recorded.',
                confirmButtonColor: '#16a34a'
            }).then(() => {
                // Here you would normally submit the form to your Laravel backend
                // For demo purposes, we'll just redirect back
                // window.history.back();
                console.log(isSaved ? 'Sale saved successfully.' : 'Sale not saved.');
                
            });
        });

        // Initialize calculations on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateSubtotal();
            calculateGrandTotal();
            calculateBalance();
        });


        function sendAjaxRequest() {
            // This function would normally send the form data to your Laravel backend via AJAX
            // For demo purposes, we'll just log the data to the console
            const formData = new FormData($('#salesForm'));
            

            $.ajax({
                url: '{{ route("admin.sales.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle success response
                    console.log('Sale saved successfully:', response);
                    return true;
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error saving sale:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Saving Sale',
                        text: 'There was an error saving the sale. Please try again.',
                        confirmButtonColor: '#dc2626'
                    });
                    return false;
                }
            });
            
            // Simulate a successful AJAX request
            return true;
        }
    </script>
</x-base>
