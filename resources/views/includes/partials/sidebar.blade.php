<div x-data="{
        isMobile: false,
        expand: false,
        grow(){
            if(!this.isMobile){
                this.expand = true;
            }
        },
        shrink(){
            this.expand = false;
        },
        checkMobileScreen(){
            this.isMobile = window.innerWidth <= 1024;
        }
     }"
    x-on:mouseenter="grow()"
    x-on:mouseleave="shrink()"
    x-init="checkMobileScreen()"
    x-on:resize.window="checkMobileScreen()"
    :class="expand ? 'w-64' : 'w-14'"
    class="block sticky min-h-screen transition-all duration-300 ease-in-out bg-white border-r md:overflow-hidden ">
    <div class="flex flex-col flex-grow min-h-screen py-5 overflow-y-auto">
        <div class="flex justify-start pl-3">
            <div class="flex items-center bg-transparent rounded-md">
                <button x-on:click="$store.sidebarExpanded.toggle()" type="button">
                    <img class="flex-shrink-0 w-auto h-8" src="{{ site_logo() }}" alt="{{ settings('name') }}">
                </button>
            </div>
        </div>

        <nav class="flex flex-col flex-1 mt-5 overflow-y-auto divide-y divide-gray-300" aria-label="Sidebar">
            <div class="flex-1 space-y-1">

                <x-sidebar-item label="Home" link="{{ url('dashboard') }}" :active="request()->is('dashboard*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-home class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="Cohorts" link="{{ route('teams.index') }}" :active="request()->is('my-teams*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-user-group class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="Courses Library" link="{{ route('courses.index') }}" :active="request()->is('courses*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-academic-cap class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="Pathway Tracks" link="{{ route('pathway.index') }}" :active="request()->is('pathway*') ">
                    <x-slot name="icon">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500">
                            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zM6 12a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75V12zm2.25 0a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zM6 15a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75V15zm2.25 0a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zM6 18a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75V18zm2.25 0a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                          </svg>

                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="Categories Manager" link="{{ route('categories.index') }}" :active="request()->is('categories*') ">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
                        </svg>
                    </x-slot>
                </x-sidebar-item>




            </div>


            <div class="flex flex-shrink-0 pt-6 pb-5 mt-6">
                <div class="flex-shrink-0 w-full space-y-1">

                    @if (auth()->user()->hasRole('admin'))
                        <x-sidebar-item label="Settings" link="{{ route('settings') }}" :active="request()->is('settings*') ">
                            <x-slot name="icon">
                                <x-heroicon-s-cog class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                            </x-slot>
                        </x-sidebar-item>

                        <x-sidebar-item label="Environment" link="{{ route('env.index') }}" :active="request()->is('env*') ">
                            <x-slot name="icon">
                                <x-heroicon-s-adjustments class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                            </x-slot>
                        </x-sidebar-item>

                        <x-sidebar-item label="Users" link="{{ route('users.index') }}" :active="request()->is('users*') ">
                            <x-slot name="icon">
                                <x-heroicon-s-users class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                            </x-slot>
                        </x-sidebar-item>

                    @endif

                    @if (null)
                        <a href="{{ route('invitations.index') }}"
                            class="flex items-center px-2 py-2 text-sm text-gray-500 rounded-md group hover:bg-gray-100">
                            <svg class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                            </svg>

                            <span class="hidden md:block" x-show="expand" x-transition>Invitations </span>

                            <span
                                class="flex items-center justify-center w-5 h-5 ml-4 text-xs text-white bg-red-500 rounded-full">2</span>
                        </a>
                    @endif

                    <x-sidebar-item label="Support" link="{{ route('support') }}" :active="request()->is('support*') ">
                        <x-slot name="icon">
                            <x-heroicon-s-chat-alt-2 class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                        </x-slot>
                    </x-sidebar-item>

                </div>
            </div>
        </nav>
    </div>
</div>
