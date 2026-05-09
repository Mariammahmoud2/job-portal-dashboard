<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit') . ' ' . $company->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-8 mb-20">

                {{-- Form Action بناءً على الـ role --}}
                @if(auth()->user()->role == 'company-owner')
                    <form action="{{ route('my-company.update') }}" method="POST">
                @else
                    <form action="{{ route('companies.update', ['company' => $company->id, 'redirectToList' => request('redirectToList')]) }}" method="POST">
                @endif
                    @csrf
                    @method('PUT')

                    <div class="mb-10 p-6 bg-gray-50 border border-gray-100 rounded-xl shadow-sm">
                        <h3 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">Company Owner Info</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="owner_name" class="block text-gray-600 text-sm font-medium mb-1">Owner Name</label>
                                <input type="text" name="owner_name" id="owner_name" 
                                       value="{{ old('owner_name', $company->owner->name ?? '') }}" 
                                       placeholder="Enter owner name"
                                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 @error('owner_name') border-red-500 @else border-gray-300 @enderror">
                                @error('owner_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="owner_email" class="block text-gray-600 text-sm font-medium mb-1">Owner Email</label>
                                <input type="email" name="owner_email" id="owner_email" 
                                       value="{{ old('owner_email', $company->owner->email ?? '') }}" 
                                       placeholder="email@example.com"
                                       readonly 
                                       class="w-full px-3 py-2 border rounded bg-gray-100 cursor-not-allowed focus:outline-none @error('owner_email') border-red-500 @else border-gray-300 @enderror">
                                @error('owner_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="relative">
                                <label for="owner_password" class="block text-gray-600 text-sm font-medium mb-1">Password (Leave blank to keep current)</label>
                                <div class="relative flex items-center">
                                    <input type="password" name="owner_password" id="owner_password" 
                                           placeholder="••••••••"
                                           class="w-full px-3 pr-10 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('owner_password') border-red-500 @else border-gray-300 @enderror">
                                    
                                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600">
                                        <svg id="eye_open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="eye_closed" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                                @error('owner_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold mb-4 text-gray-800 px-1">Company Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Company Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}" 
                                   class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @else border-gray-300 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="industry" class="block text-gray-700 font-semibold mb-2">Industry</label>
                            <select name="industry" id="industry" 
                                    class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('industry') border-red-500 @else border-gray-300 @enderror">
                                <option value="">-- Select Industry --</option>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry }}" {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>
                                        {{ $industry }}
                                    </option>
                                @endforeach
                            </select>
                            @error('industry') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="website" class="block text-gray-700 font-semibold mb-2">Website (Optional)</label>
                            <input type="url" name="website" id="website" value="{{ old('website', $company->website) }}" placeholder="https://example.com"
                                   class="w-full px-3 py-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div>
                            <label for="address" class="block text-gray-700 font-semibold mb-2">Company Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $company->address) }}" 
                                   class="w-full px-3 py-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 border-t mt-10 pt-6">
                        @if(auth()->user()->role == 'company-owner')
                            <a href="{{ route('my-company.show') }}" class="text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        @else
                            <a href="{{ route('companies.index') }}" class="text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        @endif
                        
                        <button type="submit" class="px-10 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md font-semibold transition-all active:scale-95">
                            Update Company
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('owner_password');
            const eyeOpen = document.getElementById('eye_open');
            const eyeClosed = document.getElementById('eye_closed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>