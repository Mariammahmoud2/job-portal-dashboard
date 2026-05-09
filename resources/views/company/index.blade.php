<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           
            @if(request('arcive') == 'true')
                {{ __('Archived Companies') }}
            @else
                {{ __('Companies') }}
            @endif
        </h2>
    </x-slot>

    <div class="overflow-x-auto px-6 py-6">
        <x-toast />
        
        <div class="flex justify-end items-center gap-3 mb-6">
            @if(request('arcive') == 'true')
                <a href="{{ route('companies.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2">
                    Back to Companies
                </a>
            @else
                <a href="{{ route('companies.index', ['arcive' => 'true']) }}" 
                   class="text-gray-600 hover:text-gray-800 font-medium px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    View Archive 
                </a>

                <a href="{{ route('companies.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md font-semibold transition">
                    Add Company
                </a>
            @endif
        </div>

        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mt-4">
            <thead>
                <tr>
                    <th  class="px-6 py-4 text-left text-sm font-semibold text-gray-900"> Name</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Address</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Industry</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Website</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $company)
                <tr class="border-b">
                     <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                        @if(request('arcive') == 'true')
                            <span class="text-gray-500">{{ $company->name }}</span>
                        @else
    <a href="{{ route('companies.show', $company->id) }}" class="hover:text-blue-600 hover:underline transition-colors duration-200">
        {{ $company->name }}

    </a>
    @endif
</td>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $company->address }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $company->industry }}</td>
                     <td class="px-6 py-4 text-sm text-blue-600">
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" class="hover:underline">
                                {{ Str::limit($company->website, 30) }}
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                    

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-x-3">
                            @if(request('arcive') == 'true')
                                <form action="{{ route('companies.restore', $company->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')  
                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                        🔄 Restore
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('companies.edit', $company->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    ✍️ Edit
                                </a>

                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        🗃️ Archive
                                    </button>
                                </form>
                            @endif  
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        No companies found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="flex justify-between items-center mt-4 pb-10">
            <div>
                @if ($data->onFirstPage())
                    <span class="px-5 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed text-sm font-semibold border border-gray-200">Previous</span>
                @else
                    <a href="{{ $data->appends(['archive' => request('archive')])->previousPageUrl() }}" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition text-sm font-semibold">
                        Previous
                    </a>
                @endif
            </div>

            <div>
                @if ($data->hasMorePages())
                    <a href="{{ $data->appends(['archive' => request('archive')])->nextPageUrl() }}" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition text-sm font-semibold">
                        Next
                    </a>
                @else
                    <span class="px-5 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed text-sm font-semibold border border-gray-200">Next</span>
                @endif
            </div>
    </div>
</x-app-layout>