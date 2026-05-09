<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request('archive') == 'true' ? __('Archived Users') : __('Users') }}
        </h2>
    </x-slot>

    <div class="px-6 py-6">
        <x-toast />

        <div class="flex justify-end items-center mb-6 gap-3">
            @if(request('archive') == 'true')
                <a href="{{ route('users.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2 text-sm font-medium">
                    Back to Active Users
                </a>
            @else
                <a href="{{ route('users.index', ['archive' => 'true']) }}" 
                   class="text-gray-600 hover:text-gray-800 font-medium px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                    View Archive
                </a>
            @endif
        </div>

        <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-md mb-6">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Role</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $user)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($user->role ?? 'user') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-center">
                            <div class="flex justify-center items-center gap-x-4">
                                @if(request('archive') == 'true')
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-bold flex items-center gap-1">
                                            🔄 Restore
                                        </button>
                                    </form>
                                @else
                                    {{-- التعديل هنا: منع التعديل أو الأرشفة إذا كانت الرتبة admin --}}
                                    @if($user->role !== 'admin')
                                        <a href="{{ route('users.edit', ['user' => $user->id, 'redirect_to' => 'index']) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">
                                            ✍️ Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Archive this user?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                🗃️ Archive
                                            </button>
                                        </form>
                                    @else
                                        
                                        
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-between items-center mt-4 pb-10">
            <div>
                @if ($data->onFirstPage())
                    <span class="px-5 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed text-sm font-semibold border border-gray-200">Previous</span>
                @else
                    <a href="{{ $data->appends(['archive' => request('archive')])->previousPageUrl() }}" 
                       class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition text-sm font-semibold">
                        Previous
                    </a>
                @endif
            </div>

            <div>
                @if ($data->hasMorePages())
                    <a href="{{ $data->appends(['archive' => request('archive')])->nextPageUrl() }}" 
                       class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition text-sm font-semibold">
                        Next
                    </a>
                @else
                    <span class="px-5 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed text-sm font-semibold border border-gray-200">Next</span>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>