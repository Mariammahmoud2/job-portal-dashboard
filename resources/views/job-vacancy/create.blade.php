<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-10 border border-gray-100">
                
                <div class="mb-8 border-b pb-4">
                    <h2 class="text-xl font-bold text-gray-900">Job Vacancy Details</h2>
                    <p class="text-sm text-gray-500">Enter the job vacancy details</p>
                </div>

                <form action="{{ route('job-vacancies.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 @error('title') border-red-500 @enderror">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 @error('location') border-red-500 @enderror">
                        @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Expected Salary (USD)</label>
                        <input type="text" name="salary" value="{{ old('salary') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 @error('salary') border-red-500 @enderror">
                        @error('salary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <hr class="border-gray-100">

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2">
                                <option value="Full-Time" {{ old('type') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                                <option value="Part-Time" {{ old('type') == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                                <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                            </select>
                            @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                            <select name="company_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            placeholder="Enter the job description and requirements..."
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3 text-sm @error('description') border-red-500 @enderror"
                        >{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('job-vacancies.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
                        <button type="submit" class="bg-[#2b6cb0] hover:bg-blue-800 text-white px-8 py-2 rounded shadow transition font-medium">
                            Add Job Vacancy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>