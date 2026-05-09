<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    @if(request('arcive') == 'true')
        {{ __('Archived Categories') }}
    @else
        {{ __('Categories') }}
    @endif
</h2>
    </x-slot>
       
     <div class="overflow-x-auto px-6 py-6">
        <x-toast />
         <div class="flex justify-end items-center gap-3 mb-6">
    
    @if(request('arcive') == 'true')
       
        <a href="{{ route('categories.index') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2">
             Back to Categories
        </a>
    @else
         
        <a href="{{ route('categories.index', ['arcive' => 'true']) }}" 
           class="text-gray-600 hover:text-gray-800 font-medium px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
           View Archive 
        </a>

         
        <a href="{{ route('categories.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md font-semibold transition">
            Add Category
        </a>
    @endif

</div>
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mt-4 bg-white">
            <thead>
                <tr>
                     <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900"> categoryName </th>
                     <th  class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Actions</th> 
                 </tr>
            </thead>
             <tbody>
    @forelse($data as $category)
    <tr>
        <td class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
            {{ $category->name }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex items-center gap-x-3">
                
               
                @if(request('arcive') == 'true')
                    
                    <form action="{{ route('categories.restore', $category->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')  
                        <button type="submit" class="text-green-600 hover:text-green-900 transition-colors">
                            🔄 Restore
                        </button>
                    </form>
                @else
                     
                    <a href="{{ route('categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                        ✍️Edit
                    </a>

                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                            🗃️Archive
                        </button>
                    </form>
                @endif  
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
            No categories found.
        </td>
    </tr>
    @endforelse
</tbody>
</x-app-layout>
