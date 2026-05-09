<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-10 border border-gray-100">
                
                <div class="mb-8 border-b pb-4">
                    <h2 class="text-xl font-bold text-gray-900">Edit Job Vacancy</h2>
                    <p class="text-sm text-gray-500">Update the details for: <span class="font-semibold text-blue-600">{{ $job->title }}</span></p>
                </div>
<form action="{{ route('job-vacancies.update', ['job_vacancy' => $job->id, 'redirectToList' => request('redirectToList')]) }}" method="POST" class="space-y-6">
                     @csrf
                    @method('PUT') <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title', $job->title) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 @error('title') border-red-500 @enderror">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" value="{{ old('location', $job->location) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 @error('location') border-red-500 @enderror">
                        @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Expected Salary (USD)</label>
                        <input type="text" name="salary" value="{{ old('salary', $job->salary) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 @error('salary') border-red-500 @enderror">
                        @error('salary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <hr class="border-gray-100">

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2">
                                @php $currentType = old('type', $job->type); @endphp
                                <option value="Full-Time" {{ $currentType == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                                <option value="Part-Time" {{ $currentType == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                                <option value="Contract" {{ $currentType == 'Contract' ? 'selected' : '' }}>Contract</option>
                            </select>
                            @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                            <select name="company_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $job->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Job Category</label>
                            <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
                        <textarea 
                            name="description" 
                            rows="4" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 text-sm @error('description') border-red-500 @enderror"
                        >{{ old('description', $job->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('job-vacancies.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
                        <button type="submit" class="bg-[#2b6cb0] hover:bg-blue-800 text-white px-8 py-2 rounded shadow transition font-medium">
                            Update Job Vacancy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>