<x-base>
    
    <x-slot name="page_title">{{ $page_title }}</x-slot>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4"><i class="fa-solid fa-layer-group"></i> {{ $page_title }}</h1>
        <p>This is the categories page where you can manage your categories.</p>
    </div>

    <div class="flex justify-end mb-6">
        <button onclick="openModal('add')" class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 bg-blue-500 hover:bg-blue-600 text-white shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Category
        </button>
    </div>


    <!-- Enhanced category cards with modern design, gradients, and better layout -->
    <div class="container mx-auto p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <div class="group relative bg-gradient-to-br from-white to-green-50 rounded-md shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                <!-- Decorative gradient overlay -->
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-t from-green-400/20 to-purple-500/20 rounded-md -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-500"></div>
                
                <div class="relative z-10">
                    <!-- Category Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="w-3 h-3 bg-gradient-to-b from-blue-500 to-white rounded-full mr-3"></div>
                                <h3 class="text-lg font-bold text-gray-800 transition-colors duration-200">
                                    {{ $category->category_name }}
                                </h3>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed mb-3">
                                {{ Str::limit($category->category_description ?? 'No description available', 80) }}
                            </p>
                        </div>
                    </div>

                    <!-- Product Count -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <div class="bg-green-50 text-black px-2 py-1 rounded-sm text-1xl font-semibold">
                                {{ $category->products_count ?? 0 }} Products
                            </div>
                        </div>
                        <div class="text-xs text-gray-400">
                            <i class="fa-solid fa-clock mr-1"></i>
                            {{ $category->created_at ? $category->created_at->format('M d, Y') : 'N/A' }}
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                        <button onclick="editCategory({{ $category->product_category_id }})" 
                                class="flex items-center px-3 py-2 text-xs font-medium text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-lg transition-all duration-200">
                            <i class="fa-solid fa-pen mr-1"></i> Edit
                        </button>
                        <button onclick="deleteCategory({{ $category->product_category_id }})" 
                                class="flex items-center px-3 py-2 text-xs font-medium text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-all duration-200">
                            <i class="fa-solid fa-trash mr-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Enhanced modal system supporting both add and edit modes -->
    <div id="categoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 modal-backdrop">
        <div class="fixed left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 modal-content">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-900">Add New Category</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="#" method="POST" class="p-6" id="categoryForm">
                <input type="hidden" id="categoryId" name="category_id">
                
                <div class="space-y-6">
                    <div>
                        <label for="category_name" class="block text-sm font-semibold text-gray-700 mb-2">Category Name</label>
                        <input type="text" 
                               id="category_name" 
                               name="category_name" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                               placeholder="Enter category name">
                    </div>
                    
                    <div>
                        <label for="category_description" class="block text-sm font-semibold text-gray-700 mb-2">Category Description</label>
                        <textarea id="category_description" 
                                  name="category_description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                                  placeholder="Enter category description"></textarea>
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
                        Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>

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

    <!-- Added SweetAlert2 and enhanced JavaScript functionality -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        let currentMode = 'add';
        let currentCategoryId = null;

        // =============== Modal Functions [START] ==================
        function openModal(mode = 'add', categoryData = null) {
            currentMode = mode;
            const modal = $('#categoryModal');
            const modalTitle = $('#modalTitle');
            const submitBtn = $('#submitBtn');
            const form = $('#categoryForm');
            
            if (mode === 'add') {
                modalTitle.text('Add New Category');
                submitBtn.text('Add Category');
                form[0].reset();
                $('#categoryId').val('');
            } else if (mode === 'edit' && categoryData) {
                modalTitle.text('Edit Category');
                submitBtn.text('Update Category');
                $('#categoryId').val(categoryData.product_category_id);
                $('#category_name').val(categoryData.category_name);
                $('#category_description').val(categoryData.category_description);
                currentCategoryId = categoryData.product_category_id;
            }
            
            modal.removeClass('hidden');
            $('body').css('overflow', 'hidden');
        }

        function closeModal() {
            const modal = $('#categoryModal');
            modal.addClass('hidden');
            $('body').css('overflow', 'auto');
            $('#categoryForm')[0].reset();
            currentCategoryId = null;
        }

        // =============== Category Actions [START] ==================
        function editCategory(categoryId) {

            // First Fetch the category data based on the categoryId
            $.ajax({
                url: '{{ route("admin.get_category", ":id") }}'.replace(':id', categoryId),
                type: 'GET',
                data: {
                    category_id: categoryId
                },
                success: function(response) {
                    if(response.status) {
                        const categoryData = response.data;
                        openModal('edit', categoryData);
                    } else {
                        showToast('Failed To Fetch Category Data: ','error');
                    }
                },
                error: function(xhr) {
                    showToast('Error Fetching category', 'error');
                }
            });
        }

        function deleteCategory(categoryId) {
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
                        url: `{{ route('admin.categories.delete',':id')}}`.replace(':id', categoryId),
                        type: 'POST',
                        success: function(response) {
                            if(response.status) {
                                showToast('Category deleted successfully!', 'success');
                                setTimeout(() => {
                                    // Remove the category card from DOM or reload page
                                    location.reload();
                                }, 2000);
                            } else {
                                showToast('Failed To Delete Category', 'error');
                            }
                        },
                        error: function() {
                            showToast('Error Deleting Category', 'error');
                        }
                    });
                }
            });
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

        // =============== Toast Notification System [END] ==================

        // =============== Event Listeners [START] ==================
        $(document).ready(function() {

                @if(session('no_categories'))
                    showToast('{{ session('no_categories') }}', 'error');
                @endif

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();
                
                console.log("the current category id is: ", currentCategoryId);
                
                const formData = $(this).serialize();
                const url = currentMode === 'add' ? '{{ route("admin.categories.store") }}' : `{{ route('admin.categories.update',':id') }}`.replace(':id', currentCategoryId);
                const method = currentMode === 'add' ? 'POST' : 'PUT';
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if(response.status) {
                            const message = currentMode === 'add' ? 'Category added successfully!' : 'Category updated successfully!';
                            showToast(message, 'success');
                            closeModal();
                            setTimeout(() => {
                                location.reload(); // Reload to show updated data
                            }, 2000);
                        } else {
                            const message = currentMode === 'add' ? 'Failed to save category: ' + response.message : 'Failed To update Category!';
                            showToast(message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const message = currentMode === 'add' ? 'Error saving category' : 'Error updating Category Please Try Again!';
                        showToast(message, 'error');
                    }
                });
            });

            // Close modals when clicking outside
            $('#categoryModal').on('click', function(e) {
                if (e.target === this) {
                    if (this.id === 'categoryModal') closeModal();
                    if (this.id === 'viewModal') closeViewModal();
                }
            });

            // Close modals with Escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                    closeViewModal();
                }
            });
        
        });
    </script>
</x-base>
