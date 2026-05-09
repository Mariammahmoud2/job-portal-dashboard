<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-toast />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Job Vacancy Information</h3>
                        <div class="space-y-1.5 text-sm text-gray-800">
                            <p><strong class="font-bold">Company:</strong> {{ $job->company->name ?? 'N/A' }}</p>
                            <p><strong class="font-bold">Location:</strong> {{ $job->location }}</p>
                            <p><strong class="font-bold">Type:</strong> {{ $job->type }}</p>
                            <p><strong class="font-bold">Salary:</strong> ${{ number_format($job->salary, 2) }}</p>

                            {{-- ✅ التعديل: تغيير job_categorie إلى category --}}
                            <p><strong class="font-bold">Job Category:</strong> {{ $job->category->name ?? 'Uncategorized' }}</p>

                            <p class="mt-4 max-w-4xl leading-relaxed text-gray-600">
                                <strong class="font-bold text-gray-800">Description:</strong> {{ $job->description }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $job->id, 'redirectToList' => 'false']) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded text-sm font-semibold shadow-sm transition">
                            Edit
                        </a>

                        <form action="{{ route('job-vacancies.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this job?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded text-sm font-semibold shadow-sm transition">
                                Archive
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-10 mb-6 border-b border-gray-200">
                    <ul class="flex space-x-8 -mb-px text-sm font-medium">
                        <li>
                            <a href="#" class="inline-block pb-3 px-1 text-blue-600 border-b-2 border-blue-600 transition-all font-bold">
                                Applications
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mt-4">
                    <div class="overflow-x-auto rounded-lg border border-gray-100 shadow-sm">
                        <table class="min-w-full bg-white text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-4 px-6 text-sm font-bold text-gray-900">Applicant Name</th>
                                    <th class="py-4 px-6 text-sm font-bold text-gray-900">Job Title</th>
                                    <th class="py-4 px-6 text-sm font-bold text-gray-900">Status</th>
                                    <th class="py-4 px-6 text-sm font-bold text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                {{-- ✅ التعديل: تغيير jobApplications إلى applications --}}
                                @forelse($job->applications as $application)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 text-sm text-gray-800 font-medium">
                                        {{ $application->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">
                                        {{ $job->title }}
                                    </td>
                                    <td class="py-4 px-6 text-sm">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                            @if($application->status == 'pending') bg-gray-100 text-gray-700
                                            @elseif($application->status == 'accepted') bg-green-50 text-green-700
                                            @else bg-red-50 text-red-700 @endif">
                                            {{ ucfirst($application->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-sm">
                                        <a href="{{ route('applications.show', $application->id) }}" class="text-blue-500 hover:text-blue-700 font-semibold transition underline">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-gray-400 italic">
                                        No applications submitted yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>