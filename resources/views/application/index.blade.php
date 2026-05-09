<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request('archive') == 'true' ? __('Archived Job Applications') : __('Job Applications') }}
        </h2>
    </x-slot>

    <div class="px-6 py-6">
        <x-toast />
        
        <div class="flex justify-end items-center mb-6 gap-3">
            @if(request('archive') == 'true')
                <a href="{{ route('applications.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2 text-sm font-medium">
                    Back to Active Applications
                </a>
            @else
                <a href="{{ route('applications.index', ['archive' => 'true']) }}" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                    View Archive 
                </a>
            @endif
        </div>

        <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-md mb-6">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Applicant Name</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Position (Job Vacancy)</th>
                        @if(auth()->user()->role == 'admin')
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Company</th>
                        @endif
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $application)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            @if(request('archive') == 'true')
                                <span class="text-gray-500">{{ $application->user->name ?? 'N/A' }}</span>
                            @else
                                <a href="{{ route('applications.show', $application->id) }}" 
                                   class="hover:text-blue-600 hover:underline transition-colors duration-200">
                                    {{ $application->user->name ?? 'N/A' }}
                                </a>
                            @endif
                        </td>
                        
                        {{-- Position (Job Vacancy) --}}
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $application->jobVacancie->title ?? 'N/A' }}
                        </td>

                        {{-- Company للأدمن بس --}}
                        @if(auth()->user()->role == 'admin')
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $application->jobVacancie->company->name ?? 'N/A' }}
                            </td>
                        @endif

                        {{-- Status --}}
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold 
                                {{ $application->status == 'accepted' ? 'bg-green-100 text-green-800' : 
                                   ($application->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $application->status }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 text-sm font-medium text-center">
                            <div class="flex justify-center items-center gap-x-4">
                                @if(request('archive') == 'true')
                                    <form action="{{ route('applications.restore', $application->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')  
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-bold flex items-center gap-1">
                                            🔄 Restore
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('applications.edit', ['application' => $application->id, 'redirect_to' => 'index']) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        ✍️ Edit
                                    </a>
                                    
                                    <form action="{{ route('applications.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Archive this application?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            🗃️ Archive
                                        </button>
                                    </form>
                                @endif  
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role == 'admin' ? 5 : 4 }}" class="px-6 py-10 text-center text-sm text-gray-500">
                            No applications found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

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
    </div>
</x-app-layout>