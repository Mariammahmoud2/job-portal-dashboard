<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-toast />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Company Information</h3>
                        <div class="space-y-1.5">
                            <p class="text-sm"><strong class="text-gray-700">Owner:</strong> {{ $company->owner->name ?? 'N/A' }}</p>
                            <p class="text-sm"><strong class="text-gray-700">Address:</strong> {{ $company->address }}</p>
                            <p class="text-sm"><strong class="text-gray-700">Industry:</strong> {{ $company->industry }}</p>
                            <p class="text-sm"><strong class="text-gray-700">Email:</strong> 
                                <a href="mailto:{{ $company->owner->email }}" class="text-blue-500 hover:text-blue-700 underline">
                                    {{ $company->owner->email ?? 'N/A' }}
                                </a>
                            </p>
                            <p class="text-sm"><strong class="text-gray-700">Website:</strong> 
                                <a class="text-blue-500 hover:text-blue-700 underline" href="{{ $company->website }}" target="_blank">
                                    {{ $company->website }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Edit button --}}
                        @if(auth()->user()->role == 'company-owner')
                            <a href="{{ route('my-company.edit') }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-sm font-semibold shadow-sm transition">
                                Edit
                            </a>
                        @else
                            <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-sm font-semibold shadow-sm transition">
                                Edit
                            </a>
                        @endif

                        {{-- Archive للأدمن بس --}}
                        @if(auth()->user()->role == 'admin')
                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded text-sm font-semibold shadow-sm transition">
                                    Archive
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Tabs والجداول للأدمن بس --}}
                @if(auth()->user()->role == 'admin')
                    <div class="mb-6 border-b border-gray-100">
                        <ul class="flex space-x-8 -mb-px text-sm font-medium">
                            <li>
                                <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'job-vacancies']) }}" 
                                   class="inline-block pb-3 px-1 transition-all {{ (request('tab') == 'job-vacancies' || !request('tab')) ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                    Jobs
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'applications']) }}" 
                                   class="inline-block pb-3 px-1 transition-all {{ request('tab') == 'applications' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                    Applications
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        {{-- Jobs Tab --}}
                        <div id="job-vacancies" class="{{ (request('tab') == 'job-vacancies' || !request('tab')) ? 'block' : 'hidden' }}">
                            <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
                                <table class="min-w-full bg-white text-left">
                                    <thead class="bg-gray-50/50">
                                        <tr>
                                            <th class="py-3.5 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Title</th>
                                            <th class="py-3.5 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                                            <th class="py-3.5 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Location</th>
                                            <th class="py-3.5 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($company->jobVacancies ?? [] as $job)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-6 text-sm text-gray-700 font-medium">{{ $job->title }}</td>
                                            <td class="py-4 px-6 text-sm text-gray-600">{{ $job->type }}</td>
                                            <td class="py-4 px-6 text-sm text-gray-600">{{ $job->location }}</td>
                                            <td class="py-4 px-6 text-sm text-right">
                                                <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-blue-500 hover:text-blue-700 font-semibold transition">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Applications Tab --}}
                        <div id="applications" class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
                            <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
                                <table class="min-w-full bg-white text-left">
                                    <thead class="bg-gray-50/50">
                                        <tr>
                                            <th class="py-3.5 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Applicant Name</th>
                                            <th class="py-3.5 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Job Title</th>
                                            <th class="py-3.5 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                            <th class="py-3.5 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($company->jobApplications ?? [] as $application)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-6 text-sm text-gray-800">{{ $application->user->name ?? 'N/A' }}</td>
                                            <td class="py-4 px-6 text-sm text-gray-800">{{ $application->jobVacancie->title ?? 'N/A' }}</td>
                                            <td class="py-4 px-6 text-sm">
                                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                                    {{ $application->status == 'pending' ? 'bg-yellow-50 text-yellow-700' : 'bg-green-50 text-green-700' }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 text-sm text-right">
                                                <a href="{{ route('applications.show', $application->id) }}" class="text-blue-500 hover:text-blue-700 font-semibold transition">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if(($company->jobApplications ?? collect())->isEmpty())
                                <div class="text-center py-12 text-gray-400 bg-gray-50/30 mt-4 rounded-xl border border-dashed border-gray-200">
                                    No applications submitted yet.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>