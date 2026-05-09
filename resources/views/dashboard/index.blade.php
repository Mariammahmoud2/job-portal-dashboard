<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 bg-gray-50 min-h-screen"> 

        {{-- 1. Overview Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm font-bold text-gray-800 mb-2">Active Users</p>
                <div class="flex flex-col">
                    <span class="text-4xl font-bold text-indigo-600">{{ $analytics['activeUsers'] ?? 0 }}</span>
                    <span class="text-xs text-gray-400 mt-1">Last 30 days</span>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm font-bold text-gray-800 mb-2">Active Job Postings</p>
                <div class="flex flex-col">
                    <span class="text-4xl font-bold text-indigo-600">{{ $analytics['totalJobs'] }}</span>
                    <span class="text-xs text-gray-400 mt-1">Currently active</span>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm font-bold text-gray-800 mb-2">Total Applications</p>
                <div class="flex flex-col">
                    <span class="text-4xl font-bold text-indigo-600">{{ $analytics['totalApplications'] }}</span>
                    <span class="text-xs text-gray-400 mt-1">All time</span>
                </div>
            </div>
        </div>

        {{-- 2. Most Applied Jobs Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-10">
            <div class="p-6 border-b border-gray-50">
                <h3 class="text-sm font-bold text-gray-800">Most Applied Jobs</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white">
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Job Title</th>
                            @if(auth()->user()->role == 'admin')
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Company</th>
                            @endif
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($analytics['mostAppliedJobs'] as $job)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-5 text-sm text-gray-700 font-medium">{{ $job->title }}</td>
                            @if(auth()->user()->role == 'admin')
                                <td class="px-6 py-5 text-sm text-gray-600">{{ $job->company->name ?? 'N/A' }}</td>
                            @endif
                            <td class="px-6 py-5 text-sm text-gray-800 font-bold">{{ $job->Totalcount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 3. Top Converting Job Posts --}}
        @if(isset($analytics['topConvertingJobs']) && count($analytics['topConvertingJobs']) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <div class="p-6 border-b border-gray-50">
                <h3 class="text-sm font-bold text-gray-800">Top Converting Job Posts</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white">
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Job Title</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Views</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Applications</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($analytics['topConvertingJobs'] as $job)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-5 text-sm text-gray-700 font-medium">{{ $job->title }}</td>
                            <td class="px-6 py-5 text-sm text-gray-800 font-bold">{{ $job->view_count }}</td>
                            <td class="px-6 py-5 text-sm text-gray-800 font-bold">{{ $job->Totalcount }}</td>
                            <td class="px-6 py-5 text-sm text-gray-700 font-medium">{{ $job->conversion_rate }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>