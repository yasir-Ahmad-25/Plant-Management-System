<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Font Awesome Icon Link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login</title>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-5 py-10">

        <div class="flex justify-center items-center h-screen">
            <div class="w-full max-w-md">
                <form action="{{ route('auth.authenticate') }}" method="POST" class="bg-white shadow-md inset-shadow-xs rounded px-8 pt-6 pb-8 mb-4 rounded-md">
                    @csrf
                    <div class="flex justify-center">
                        <img src="{{ asset('images/Logo.png')}}" alt="" class="w-14 h-14 rounded-md bg-stone-100">
                        <h2 class="text-3xl font-bold text-gray-700 ml-2 mt-2">Planter</h2>
                    </div>

                    
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="email" name="email" id="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input type="password" name="password" id="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    @if(session('error'))
                        <div class="flex justify-left px-2 bg-red-500 text-white font-bold py-2 rounded mb-4 errorDiv">
                            <i class="fa-solid fa-square-xmark mt-1"></i>
                            <span class="ml-2">{{session('error')}}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-800 cursor-pointer text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        @if(session('error'))
            setTimeout(() => {
                $('.errorDiv').addClass('hidden');
            },5000);
        @endif

    </script>
</body>
</html>