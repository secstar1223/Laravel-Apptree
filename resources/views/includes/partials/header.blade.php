<header class="px-6 py-4 bg-white md:py-8 md:px-16">
    <div class="flex items-center justify-between">
        <section>
            <livewire:search-result>
        </section>

        <section>

            <div class="flex items-center justify-end gap-6">


                <a href="{{ route('courses.index') }}" class="hidden text-sm text-darkgreen md:block">
                    My Courses
                </a>

                <a href="{{ route('support') }}" class="hidden text-sm text-darkgreen md:block">
                    Support
                </a>


                <x-dropdown>
                    <x-slot name="button">
                        <button type="button" class="">
                            <x-heroicon-s-bell class="w-5 h-5 mt-1 text-darkgreen"/>
                        </button>
                    </x-slot>
                    <div class="p-8 w-96">
                        <h3 class="font-bold text-darkgreen">Notifications</h3>

                        <p class="mt-4 text-sm font-normal text-gray-600">You have no new notifications.</p>
                    </div>
                </x-dropdown>


                <x-dropdown>
                    <x-slot name="button">
                        <button type="button" class="flex items-center justify-center w-8 h-8 overflow-hidden text-xs transition duration-200 ease-in-out bg-indigo-200 rounded-full text-darkgreen g-5 hover:bg-indigo-300">
                            <img src="{!! auth()->user()->profile_photo_url !!}" class="rounded-full">
                        </button>
                    </x-slot>
                    <div class="w-64">
                        <section>

                            <!-- Profile -->
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                             <!-- Team Management -->
                             <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Team') }}
                            </div>

                            <!-- Team Settings -->
                            @if(Auth::user()->currentTeam)
                            <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                {{ __('Team Settings') }}
                            </x-dropdown-link>
                            @endif

                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Team') }}
                                </x-dropdown-link>
                            @endcan

                            <div class="border-t border-gray-200"></div>

                            <!-- Team Switcher -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" />
                            @endforeach
                        </section>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 group hover:bg-gray-200">
                                <x-heroicon-s-logout  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </x-dropdown>

            </div>
        </section>
    </div>
</header>
