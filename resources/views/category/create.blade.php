<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(' add job-Categories') }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto px-6 py-6">
        <form action="{{ route('categories.store') }}" method="POST" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            @csrf
             <div class="mb-4">
    <label for="name" class="block text-gray-700 font-semibold mb-2">Category Name</label>
    
    <input type="text" name="name" id="name" value="{{ old('name') }}" 
           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring 
           @error('name') border-red-500 ring-1 ring-red-500 @else border-gray-300 focus:border-blue-300 @enderror">

    @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
            <div class="flex justify-end items-center gap-3">
                
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                    Add Category
                </button>
                  <a href="{{ route('categories.index') }}" 
       class="text-gray-500 hover:text-gray-700 transition">
        Cancel
    </a>
            </div>
        </form>
    </div>
</x-app-layout>
