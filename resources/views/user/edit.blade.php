<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User Password
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-10 border border-gray-100">

                {{-- Read-only Details --}}
                <div class="mb-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">User Details</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">User Name</p>
                            <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">User Email</p>
                            <p class="text-sm font-medium text-gray-800">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">User Role</p>
                            <p class="text-sm font-medium text-gray-800">{{ $user->role ?? 'user' }}</p>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100 mb-6">

                {{-- Password Form --}}
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="redirect_to" value="{{ request('redirect_to', 'index') }}">

                     <div>
    <label class="block text-xs text-gray-500 mb-1">Change User Password</label>
    <div class="relative w-full">
        <input type="password" name="password" id="passwordInput"
               class="w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 pl-3 pr-10 @error('password') border-red-500 @enderror">
        
        <button type="button" onclick="togglePassword()"
                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
            {{-- Eye Open --}}
            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            {{-- Eye Closed --}}
            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.087-3.368M9.88 9.88a3 3 0 104.24 4.24M3 3l18 18" />
            </svg>
        </button>
    </div>
    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('users.index') }}" 
                           class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition font-medium text-sm">
                            Update User Password
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    }
}
</script>