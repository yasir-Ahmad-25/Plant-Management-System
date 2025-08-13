<x-base>
    <x-slot name="page_title">{{ $page_title }}</x-slot>


    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4"><i class="fa-solid fa-layer-group"></i> {{ $page_title }}</h1>
        <p>This is the Products page where you can manage your Products.</p>
    </div>
    
    <div class="flex justify-end mb-6">
        <button onclick="openModal('add')" class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 bg-green-500 hover:bg-green-600 text-white shadow-sm">
            <i class="fa-solid fa-seedling mr-3"></i>
            Add New Product
        </button>
    </div>


    <div class="container mx-auto">
        <!-- Enhanced table design with modern styling -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <table class="w-full table-auto">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                            <i class="fa-solid fa-box text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $product->product_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $product->category_name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-green-600">${{ number_format($product->product_price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 max-w-xs truncate" title="{{ $product->product_description }}">
                                    {{ $product->product_description }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button onclick="editProduct({{ $product->product_id }})" 
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-md transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                        <i class="fa-solid fa-pen mr-1"></i> Edit
                                    </button>
                                    <button onclick="deleteProduct({{ $product->product_id }})" 
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-red-500 hover:bg-red-600 rounded-md transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                        <i class="fa-solid fa-trash mr-1"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    {{-- PRODUCT MODAL [START] --}}
        <div id="productModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 modal-backdrop">
            <div class="fixed left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 modal-content">
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <h3 id="modalTitle" class="text-xl font-bold text-gray-900">Add New Product</h3>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form action="#" method="POST" class="p-6" id="productForm">
                    <input type="hidden" id="productId" name="product_id">
                    
                    <div class="space-y-6">
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                            <select 
                                name="category_id" 
                                id="category_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none"
                            >
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->product_category_id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div>
                            <label for="product_name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name</label>
                            <input type="text" 
                                    id="product_name" 
                                    name="product_name" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Enter Product name">
                        </div>
                        
                        <div>
                            <label for="product_price" class="block text-sm font-semibold text-gray-700 mb-2">Product Price</label>
                            <input type="text" 
                                    id="product_price" 
                                    name="product_price" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Enter Product Price">
                        </div>

                        <div>
                            <label for="product_description" class="block text-sm font-semibold text-gray-700 mb-2">Product Description</label>
                            <textarea id="product_description" 
                                    name="product_description" 
                                    rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Enter Product description"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-8">
                        <button type="button" 
                                onclick="closeModal()"
                                class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit" 
                                id="submitBtn"
                                class="px-6 py-3 text-sm font-medium text-white bg-blue-500 hover:bg-blue-700 rounded-md transition-all duration-200 shadow-lg">
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    {{-- PRODUCT MODAL [END] --}}


        <!-- Toast Notification System -->
        <div id="toast" class="hidden fixed top-4 right-4 z-50 max-w-sm w-full">
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-4">
                <div class="flex items-center">
                    <div id="toastIcon" class="flex-shrink-0 w-6 h-6 mr-3"></div>
                    <div class="flex-1">
                        <p id="toastMessage" class="text-sm font-medium text-gray-900"></p>
                    </div>
                    <button onclick="hideToast()" class="ml-3 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        let currentMode = 'add';
        let productId = null;
        function openModal(mode = 'add', ProductData = null) {
            currentMode = mode;
            const modal = $('#productModal');
            const modalTitle = $('#modalTitle');
            const submitBtn = $('#submitBtn');
            const form = $('#productForm');
            
            if (mode === 'add') {
                modalTitle.text('Add New Product');
                submitBtn.text('Add Product');
                form[0].reset();
            } else if (mode === 'edit' && ProductData) {
                modalTitle.text('Edit Product');
                submitBtn.text('Update Product');
                productId = ProductData.product_id;
                $('#productId').val(productId);
                $('#category_id').val(ProductData.product_category_id);
                $('#product_name').val(ProductData.product_name);   
                $('#product_price').val(ProductData.product_price);
                $('#product_description').val(ProductData.product_description);
                $('#category_id').trigger('change');
            }
            
            modal.removeClass('hidden');
            $('body').css('overflow', 'hidden');
        }
        
        function closeModal() {
            $('#productModal').addClass('hidden');
            $('body').css('overflow', 'auto');
        }
  
        
        // =============== Toast Notification System [START] ==================
        function showToast(message, type = 'success') {
            const toast = $('#toast');
            const toastMessage = $('#toastMessage');
            const toastIcon = $('#toastIcon');
            
            toastMessage.text(message);
            
            if (type === 'success') {
                toastIcon.html('<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>');
            } else if (type === 'error') {
                toastIcon.html('<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>');
            }
            
            toast.removeClass('hidden');
            
            setTimeout(() => {
                hideToast();
            }, 4000);
        }

        function hideToast() {
            $('#toast').addClass('hidden');
        }


        function editProduct(product_id) {

            // First Fetch the category data based on the product_id
            $.ajax({
                url: '{{ route("admin.get_product", ":id") }}'.replace(':id', product_id),
                type: 'GET',
                success: function(response) {
                    if(response.status) {
                        const productData = response.data;
                        openModal('edit', productData);
                    } else {
                        showToast('Failed To Fetch Product Data: ','error');
                    }
                },
                error: function(xhr) {
                    showToast('Error Fetching Product', 'error');
                }
            });
        }

        function deleteProduct(product_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform delete action via AJAX
                    $.ajax({
                        url: `{{ route('admin.products.delete',':id')}}`.replace(':id', product_id),
                        type: 'POST',
                        success: function(response) {
                            if(response.status) {
                                showToast('Product Deleted successfully!', 'success');
                                setTimeout(() => {
                                    // Remove the product card from DOM or reload page
                                    location.reload();
                                }, 2000);
                            } else {
                                showToast('Failed To Delete Product', 'error');
                            }
                        },
                        error: function() {
                            showToast('Error Deleting Product', 'error');
                        }
                    });
                }
            });
        }


        // =============== Toast Notification System [END] ==================

        $(document).ready(function(){



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                
                console.log("the current product id is: ", productId);
                
                const formData = $(this).serialize();
                const url = currentMode === 'add' ? '{{ route("admin.products.store") }}' : `{{ route('admin.products.update',':id') }}`.replace(':id', productId);
                const method = currentMode === 'add' ? 'POST' : 'PUT';
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if(response.status) {
                            const message = currentMode === 'add' ? 'Product added successfully!' : 'Product updated successfully!';
                            showToast(message, 'success');
                            closeModal();
                            setTimeout(() => {
                                location.reload(); // Reload to show updated data
                            }, 2000);
                        } else {
                            const message = currentMode === 'add' ? 'Failed to save Product: ' + response.message : 'Failed To update Product!';
                            showToast(message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const message = currentMode === 'add' ? 'Error saving Product' : 'Error updating Product Please Try Again!';
                        showToast(message, 'error');
                    }
                });
            });


            // Close modals when clicking outside
            $('#productModal').on('click', function(e) {
                if (e.target === this) {
                    if (this.id === 'productModal') closeModal();
                }
                
            });

            // Close modals with Escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        
        })
   </script>
</x-base>