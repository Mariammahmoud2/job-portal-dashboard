<nav class="w-[250px] bg-white h-screen border-r border-gray-200 flex flex-col">
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="h-8 w-auto fill-current text-gray-800" />
            <span class="text-lg font-bold text-gray-800">{{ __('Back-office') }}</span>
        </a>
    </div>

    <div class="flex-1 px-4 py-6">
        <ul class="flex flex-col space-y-2">
            {{-- Dashboard (admin + company-owner) --}}
            <li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="w-full inline-block">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </li>

            {{-- Admin Only --}}
            @if(auth()->user()->role == 'admin')
                <li>
                    <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')" class="w-full inline-block">
                        {{ __('Companies') }}
                    </x-nav-link>
                </li>

                <li>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="w-full inline-block">
                        {{ __('Job Categories') }}
                    </x-nav-link>
                </li>

                <li>
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="w-full inline-block">
                        {{ __('Users') }}
                    </x-nav-link>
                </li>
            @endif

            {{-- Company Owner Only --}}
            @if(auth()->user()->role == 'company-owner')
                <li>
                    <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.*')" class="w-full inline-block">
                        {{ __('My Company') }}
                    </x-nav-link>
                </li>
            @endif

            {{-- Admin + Company Owner --}}
            <li>
                <x-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.*')" class="w-full inline-block">
                    {{ __('Job Applications') }}
                </x-nav-link>
            </li>

            <li>
                <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.*')" class="w-full inline-block">
                    {{ __('Job Vacancies') }}
                </x-nav-link>
            </li>
        </ul>
    </div>

    <div class="p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-nav-link :href="route('logout')" class="text-red-500 w-full inline-block"
                onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-nav-link>
        </form>
    </div>
</nav>