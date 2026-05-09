<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $application->user->name ?? 'N/A' }} | Applied to {{ $application->jobVacancie->title ?? 'N/A' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-toast />

            

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                {{-- Header: Details + Buttons --}}
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-base font-bold text-gray-800 mb-3">Application Details</h3>
                        <div class="space-y-1.5 text-sm">
                            <p><strong>Applicant:</strong> {{ $application->user->name ?? 'N/A' }}</p>
                            <p><strong>Job Vacancy:</strong> {{ $application->jobVacancie->title ?? 'N/A' }}</p>
                            <p><strong>Company:</strong> {{ $application->jobVacancie->company->name ?? 'N/A' }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($application->status) }}</p>
                            <!-- <p>
                                <strong>Resume:</strong> 
                                @if($application->resume)
                                    <a href="{{ $application->resume->file_url }}" 
                                       target="_blank"
                                       class="text-blue-500 hover:text-blue-700 underline">
                                        {{ $application->resume->file_name }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </p> -->
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Edit بيبعت redirect_to=show --}}
                        <a href="{{ route('applications.edit', ['application' => $application->id, 'redirect_to' => 'show']) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-sm font-semibold shadow-sm transition">
                            Edit
                        </a>
                        <form action="{{ route('applications.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Archive this application?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded text-sm font-semibold shadow-sm transition">
                                Archive
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="mb-6 border-b border-gray-100">
                    <ul class="flex space-x-8 -mb-px text-sm font-medium">
                        <li>
                            <a href="{{ route('applications.show', ['application' => $application->id, 'tab' => 'resume']) }}"
                               class="inline-block pb-3 px-1 transition-all {{ (request('tab') == 'resume' || !request('tab')) ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                Resume
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('applications.show', ['application' => $application->id, 'tab' => 'ai-feedback']) }}"
                               class="inline-block pb-3 px-1 transition-all {{ request('tab') == 'ai-feedback' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                AI Feedback
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Tab: Resume --}}
                <div class="{{ (request('tab') == 'resume' || !request('tab')) ? 'block' : 'hidden' }}">
                    @if($application->resume)

                        {{-- زرار فتح الملف --}}
                        <div class="mb-4">
                            <a href="{{ $application->resume->file_url }}" 
                               target="_blank"
                               class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
                                📄 View Resume File
                            </a>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
                            <table class="min-w-full bg-white text-left">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="py-3.5 px-6 text-sm font-semibold text-gray-700">Summary</th>
                                        <th class="py-3.5 px-6 text-sm font-semibold text-gray-700">Skills</th>
                                        <th class="py-3.5 px-6 text-sm font-semibold text-gray-700">Experience</th>
                                        <th class="py-3.5 px-6 text-sm font-semibold text-gray-700">Education</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-top">
                                        <td class="py-4 px-6 text-sm text-gray-700">{{ $application->resume->summary ?? 'N/A' }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-700">{{ $application->resume->skills ?? 'N/A' }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-700">{{ $application->resume->experience ?? 'N/A' }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-700">{{ $application->resume->education ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-400 bg-gray-50/30 rounded-xl border border-dashed border-gray-200">
                            No resume attached.
                        </div>
                    @endif
                </div>

                {{-- Tab: AI Feedback --}}
                <div class="{{ request('tab') == 'ai-feedback' ? 'block' : 'hidden' }}">
                    @if($application->ai_generated_feedback)
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-sm font-semibold text-gray-700">AI Score:</span>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $application->ai_generated_score ?? 'N/A' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $application->ai_generated_feedback }}</p>
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-400 bg-gray-50/30 rounded-xl border border-dashed border-gray-200">
                            No AI feedback available yet.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>