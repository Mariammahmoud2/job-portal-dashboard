<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Applicant Status
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-10 border border-gray-100">

                {{-- Read-only Details --}}
                <div class="mb-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Job Application Details</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">Applicant Name</p>
                            <p class="text-sm font-medium text-gray-800">{{ $application->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Job Vacancy</p>
                            <p class="text-sm font-medium text-gray-800">{{ $application->jobVacancie->title ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Company</p>
                            <p class="text-sm font-medium text-gray-800">{{ $application->jobVacancie->company->name ?? 'N/A' }}</p>
                        </div>
                        @if($application->ai_generated_score)
                        <div>
                            <p class="text-xs text-gray-500">AI Generated Score</p>
                            <p class="text-sm font-medium text-gray-800">{{ $application->ai_generated_score }}</p>
                        </div>
                        @endif
                        @if($application->ai_generated_feedback)
                        <div>
                            <p class="text-xs text-gray-500">AI Generated Feedback</p>
                            <p class="text-sm text-gray-700">{{ $application->ai_generated_feedback }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <hr class="border-gray-100 mb-6">

                {{-- Edit Form --}}
                <form action="{{ route('applications.update', $application->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- هنا بنحفظ من فين جاي --}}
                    <input type="hidden" name="redirect_to" value="{{ request('redirect_to', 'show') }}">

                    <div class="mb-6">
                        <label class="block text-xs text-gray-500 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 text-sm">
                            <option value="pending"  {{ $application->status == 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted - Qualified</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end items-center gap-4">
                        {{-- Cancel يرجع لنفس المكان --}}
                        @if(request('redirect_to') == 'index')
                            <a href="{{ route('applications.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
                        @else
                            <a href="{{ route('applications.show', $application->id) }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
                        @endif

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition font-medium text-sm">
                            Update Applicant Status
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>