<x-base>
    <x-slot name="page_title">{{ $page_title }}</x-slot>

    <h1>{{ $page_title}}</h1>
    

    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.sales.create_sale_view')}}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 bg-green-500 hover:bg-green-600 text-white shadow-sm">
            <i class="fa-solid fa-seedling mr-3"></i>
            Add New Sales
        </a>
    </div>

</x-base>