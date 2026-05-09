<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(request('archive') == 'true')
                {{ __('Archived Job Vacancies') }}
            @else
                {{ __('Job Vacancies') }}
            @endif
        </h2>
    </x-slot>

    <div class="px-6 py-6">
        <x-toast />
        
        <div class="flex justify-end items-center mb-6 gap-3">
            @if(request('archive') == 'true')
                <a href="{{ route('job-vacancies.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2 text-sm font-medium">
                    Back to Vacancies
                </a>
            @else
                <a href="{{ route('job-vacancies.index', ['archive' => 'true']) }}" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                    View Archive 
                </a>
                <a href="{{ route('job-vacancies.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md font-semibold transition text-sm">
                    Add Job Vacancy
                </a>
            @endif
        </div>

        <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-md mb-6">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Job Title</th>
                        @if(auth()->user()->role == 'admin')
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Company</th>
                        @endif
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Location</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Salary</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Type</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $job)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">
                                @if(request('archive') == 'true')
                                    {{ $job->title }}
                                @else
                                    <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-blue-600 hover:underline">
                                        {{ $job->title }}
                                    </a>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 truncate w-48">{{ Str::limit($job->description, 40) }}</div>
                        </td>

                        @if(auth()->user()->role == 'admin')
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $job->company->name ?? 'N/A' }}</td>
                        @endif

                        <td class="px-6 py-4 text-sm text-gray-600">{{ $job->location }}</td>
                        <td class="px-6 py-4 text-sm text-green-600 font-medium">
                            {{ $job->salary ? number_format($job->salary) . ' EGP' : 'Negotiable' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-md border border-blue-100 text-xs font-semibold">
                                {{ $job->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex justify-center items-center gap-x-4">
                                @if(request('archive') == 'true')
                                    <form action="{{ route('job-vacancies.restore', $job->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')  
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-bold">
                                            🔄 Restore
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('job-vacancies.edit', $job->id) }}" class="text-indigo-600 hover:text-indigo-900">✍️ Edit</a>
                                    
                                    <form action="{{ route('job-vacancies.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Archive this job?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">🗃️ Archive</button>
                                    </form>
                                @endif  
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role == 'admin' ? 6 : 5 }}" class="px-6 py-10 text-center text-sm text-gray-500">
                            No job vacancies found in {{ request('archive') == 'true' ? 'archive' : 'list' }}.
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