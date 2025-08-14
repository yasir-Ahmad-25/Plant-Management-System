<x-base>
    <x-slot name="page_title">{{ $page_title }}</x-slot>
    
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 p-6">
        <div class="mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-green-800 mb-2">{{ $page_title }}</h1>
                <p class="text-green-600">Manage your company profile and system credentials</p>
            </div>

            <form id="settingsForm" class="space-y-8">
                @csrf
                
                <!-- Company Profile Section -->
                <div class="bg-white rounded-lg shadow-sm border border-green-200 overflow-hidden">
                    <div class="bg-green-50 px-6 py-4 border-b border-green-200">
                        <h2 class="text-xl font-semibold text-green-800 flex items-center">
                            <i class="fa-solid fa-building mr-3 text-green-600"></i>
                            Company Profile
                        </h2>
                        <p class="text-sm text-green-600 mt-1">Update your company information and branding</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Company Information -->
                            <div class="space-y-6">
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-green-700 mb-2">
                                        Company Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="company_name" 
                                           name="company_name" 
                                           value="{{ $company_info->company_name ?? 'Company Name' }}"
                                           class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                           placeholder="Enter company name"
                                           required>
                                </div>

                                <div>
                                    <label for="company_address" class="block text-sm font-medium text-green-700 mb-2">
                                        Company Address <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="company_address" 
                                              name="company_address" 
                                              rows="3"
                                              class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                              placeholder="Enter company address"
                                              required>{{ $company_info->company_address ?? 'Company Address'}}</textarea>
                                </div>

                                <div>
                                    <label for="company_phone" class="block text-sm font-medium text-green-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           id="company_phone" 
                                           name="company_phone" 
                                           value="{{ $company_info->company_phone ?? '252 61XXXXXXX' }}"
                                           class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                           placeholder="Enter phone number"
                                           required>
                                </div>

                                <div>
                                    <label for="company_email" class="block text-sm font-medium text-green-700 mb-2">
                                        Company Email
                                    </label>
                                    <input type="email" 
                                           id="company_email" 
                                           name="company_email" 
                                           value="{{ $company_info->company_email ?? 'info@planter.com' }}"
                                           class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                           placeholder="Enter company email">
                                </div>
                            </div>

                            <!-- Logo Upload Section -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-green-700 mb-2">
                                        Company Logo
                                    </label>
                                    
                                    <!-- Logo Preview -->
                                    <div class="mb-4">
                                        <div id="logoPreview" class="w-32 h-32 border-2 border-dashed border-green-300 rounded-md flex items-center justify-center bg-green-50 overflow-hidden">
                                            <div id="logoPlaceholder" class="text-center">
                                                <i class="fa-solid fa-image text-3xl text-green-400 mb-2"></i>
                                                <p class="text-sm text-green-600">No logo uploaded</p>
                                            </div>
                                            <img id="logoImage" src="/placeholder.svg" alt="Company Logo" class="w-full h-full object-cover hidden">
                                        </div>
                                    </div>

                                    <!-- Upload Button -->
                                    <div class="flex items-center space-x-3">
                                        <label for="logo_upload" class="cursor-pointer inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                            <i class="fa-solid fa-upload mr-2"></i>
                                            Choose Logo
                                        </label>
                                        <input type="file" 
                                               id="logo_upload" 
                                               name="company_logo" 
                                               accept="image/*" 
                                               class="hidden">
                                        <button type="button" 
                                                id="removeLogo" 
                                                class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors duration-200 hidden">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-green-600 mt-2">Recommended: 200x200px, PNG or JPG format</p>
                                </div>

                                <div>
                                    <label for="company_slogan" class="block text-sm font-medium text-green-700 mb-2">
                                        Company Slogan
                                    </label>
                                    <input type="text" 
                                           id="company_slogan" 
                                           name="company_slogan" 
                                           value="{{$company_info->company_slogan ?? 'Growing green dreams together!'}}"
                                           class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                           placeholder="Enter company slogan">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Credentials Section -->
                <div class="bg-white rounded-lg shadow-sm border border-green-200 overflow-hidden">
                    <div class="bg-green-50 px-6 py-4 border-b border-green-200">
                        <h2 class="text-xl font-semibold text-green-800 flex items-center">
                            <i class="fa-solid fa-shield-halved mr-3 text-green-600"></i>
                            System Credentials
                        </h2>
                        <p class="text-sm text-green-600 mt-1">Update your login credentials and security settings</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div>
                                    <label for="admin_email" class="block text-sm font-medium text-green-700 mb-2">
                                        Admin Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="admin_email" 
                                           name="admin_email" 
                                           value="{{ $user_email ?? 'admin@planter.com'}}"
                                           class="w-full px-4 py-3 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                           placeholder="Enter admin email"
                                           required>
                                </div>

                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-green-700 mb-2">
                                        Current Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               id="current_password" 
                                               name="current_password" 
                                               class="w-full px-4 py-3 pr-12 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                               placeholder="Enter current password"
                                               required>
                                        <button type="button" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                onclick="togglePassword('current_password')">
                                            <i class="fa-solid fa-eye text-green-500 hover:text-green-600" id="current_password_icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-green-700 mb-2">
                                        New Password
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               id="new_password" 
                                               name="new_password" 
                                               class="w-full px-4 py-3 pr-12 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                               placeholder="Enter new password (leave blank to keep current)">
                                        <button type="button" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                onclick="togglePassword('new_password')">
                                            <i class="fa-solid fa-eye text-green-500 hover:text-green-600" id="new_password_icon"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <div class="text-xs text-green-600">
                                            Password strength: <span id="passwordStrength" class="font-medium">-</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                            <div id="passwordStrengthBar" class="h-1 rounded-full transition-all duration-300" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="confirm_password" class="block text-sm font-medium text-green-700 mb-2">
                                        Confirm New Password
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               id="confirm_password" 
                                               name="new_password_confirmation" 
                                               class="w-full px-4 py-3 pr-12 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                               placeholder="Confirm new password">
                                        <button type="button" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                onclick="togglePassword('confirm_password')">
                                            <i class="fa-solid fa-eye text-green-500 hover:text-green-600" id="confirm_password_icon"></i>
                                        </button>
                                    </div>
                                    <div id="passwordMatch" class="text-xs mt-1 hidden"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6">
                    <button type="button" 
                            id="cancelBtn"
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-md transition-colors duration-200 border border-gray-300">
                        <i class="fa-solid fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button type="submit" 
                            id="updateBtn"
                            class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-md transition-colors duration-200 shadow-sm">
                        <i class="fa-solid fa-save mr-2"></i>
                        <span id="updateBtnText">Update Settings</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="bg-white border-l-4 rounded-md shadow-lg p-4 max-w-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i id="toastIcon" class="text-xl"></i>
                </div>
                <div class="ml-3">
                    <p id="toastMessage" class="text-sm font-medium text-gray-900"></p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="hideToast()" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Logo preview functionality
        document.getElementById('logo_upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const logoImage = document.getElementById('logoImage');
                    const logoPlaceholder = document.getElementById('logoPlaceholder');
                    const removeLogo = document.getElementById('removeLogo');
                    
                    logoImage.src = e.target.result;
                    logoImage.classList.remove('hidden');
                    logoPlaceholder.classList.add('hidden');
                    removeLogo.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove logo functionality
        document.getElementById('removeLogo').addEventListener('click', function() {
            const logoImage = document.getElementById('logoImage');
            const logoPlaceholder = document.getElementById('logoPlaceholder');
            const removeLogo = document.getElementById('removeLogo');
            const logoUpload = document.getElementById('logo_upload');
            
            logoImage.src = '';
            logoImage.classList.add('hidden');
            logoPlaceholder.classList.remove('hidden');
            removeLogo.classList.add('hidden');
            logoUpload.value = '';
        });

        // Password visibility toggle
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '_icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        document.getElementById('new_password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthText = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('passwordStrengthBar');
            
            if (password.length === 0) {
                strengthText.textContent = '-';
                strengthBar.style.width = '0%';
                strengthBar.className = 'h-1 rounded-full transition-all duration-300';
                return;
            }
            
            let strength = 0;
            let strengthLabel = '';
            let strengthColor = '';
            
            // Check password criteria
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            switch (strength) {
                case 0:
                case 1:
                    strengthLabel = 'Very Weak';
                    strengthColor = 'bg-red-500';
                    break;
                case 2:
                    strengthLabel = 'Weak';
                    strengthColor = 'bg-orange-500';
                    break;
                case 3:
                    strengthLabel = 'Fair';
                    strengthColor = 'bg-yellow-500';
                    break;
                case 4:
                    strengthLabel = 'Good';
                    strengthColor = 'bg-blue-500';
                    break;
                case 5:
                    strengthLabel = 'Strong';
                    strengthColor = 'bg-green-500';
                    break;
            }
            
            strengthText.textContent = strengthLabel;
            strengthBar.style.width = (strength * 20) + '%';
            strengthBar.className = `h-1 rounded-full transition-all duration-300 ${strengthColor}`;
        });

        // Password confirmation checker
        document.getElementById('confirm_password').addEventListener('input', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = e.target.value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (confirmPassword.length === 0) {
                matchDiv.classList.add('hidden');
                return;
            }
            
            matchDiv.classList.remove('hidden');
            
            if (newPassword === confirmPassword) {
                matchDiv.textContent = 'Passwords match';
                matchDiv.className = 'text-xs mt-1 text-green-600';
            } else {
                matchDiv.textContent = 'Passwords do not match';
                matchDiv.className = 'text-xs mt-1 text-red-600';
            }
        });

        // Form submission
        document.getElementById('settingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const updateBtn = document.getElementById('updateBtn');
            const updateBtnText = document.getElementById('updateBtnText');
            
            // Show loading state
            updateBtn.disabled = true;
            updateBtnText.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Updating...';
            
            sendAjaxRequest();
        });

        // Cancel button
        document.getElementById('cancelBtn').addEventListener('click', function() {
            if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                // Reset form or redirect
                document.getElementById('settingsForm').reset();
                showToast('Changes cancelled', 'info');
            }
        });

        // Toast notification functions
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastIcon = document.getElementById('toastIcon');
            const toastMessage = document.getElementById('toastMessage');
            const toastContainer = toast.querySelector('div');
            
            // Set icon and color based on type
            let iconClass = '';
            let borderColor = '';
            
            switch (type) {
                case 'success':
                    iconClass = 'fa-solid fa-check-circle text-green-500';
                    borderColor = 'border-green-500';
                    break;
                case 'error':
                    iconClass = 'fa-solid fa-exclamation-circle text-red-500';
                    borderColor = 'border-red-500';
                    break;
                case 'warning':
                    iconClass = 'fa-solid fa-exclamation-triangle text-yellow-500';
                    borderColor = 'border-yellow-500';
                    break;
                case 'info':
                    iconClass = 'fa-solid fa-info-circle text-blue-500';
                    borderColor = 'border-blue-500';
                    break;
            }
            
            toastIcon.className = iconClass;
            toastContainer.className = `bg-white border-l-4 rounded-md shadow-lg p-4 max-w-sm ${borderColor}`;
            toastMessage.textContent = message;
            
            // Show toast
            toast.classList.remove('translate-x-full');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                hideToast();
            }, 5000);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('translate-x-full');
        }

        // Auto-save functionality (optional)
        let autoSaveTimeout;
        const formInputs = document.querySelectorAll('#settingsForm input, #settingsForm textarea');
        
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(() => {
                    // Auto-save draft (you can implement this based on your needs)
                    console.log('Auto-saving draft...');
                }, 3000);
            });
        });


        function sendAjaxRequest() {
            // This function would normally send the form data to your Laravel backend via AJAX
            const formData = new FormData($('#settingsForm')[0]);
            

            $.ajax({
                url: '{{ route("admin.settings.update") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status){
                        // Reset button state
                        updateBtn.disabled = false;
                        updateBtnText.innerHTML = '<i class="fa-solid fa-save mr-2"></i>Update Settings';
                        
                        // Show success toast
                        showToast('Settings updated successfully!', 'success');
                    }else{
                        // Reset button state
                        updateBtn.disabled = false;
                        updateBtnText.innerHTML = '<i class="fa-solid fa-save mr-2"></i>Update Settings';
                        
                        // Show success toast
                        showToast('Failed To Update Settings!', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error saving sale:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Saving Sale',
                        text: '',
                        confirmButtonColor: '#dc2626'
                    });
                    // Reset button state
                    updateBtn.disabled = false;
                    updateBtnText.innerHTML = '<i class="fa-solid fa-save mr-2"></i>Update Settings';
                    
                    // Show success toast
                    showToast('There was an error update the settings. Please try again !', 'error');
                }
            });
            
            // Simulate a successful AJAX request
            return true;
        }
    
    </script>
</x-base>
