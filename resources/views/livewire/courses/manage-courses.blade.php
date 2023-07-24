<div>
    <header class="flex items-center justify-between px-4 py-6 lg:px-16">
        <h1 class="text-xl font-bold leading-7 lg:text-3xl text-darkgreen sm:leading-9">Course Library</h1>
        <div>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('courses.create') }}" type="button" class="inline-flex items-center w-full btn-primary">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>

                Create Course
            </a>
            @endif
        </div>
    </header>
    <div class="px-4 py-12 bg-gray-100 lg:px-16">
        <section>

            <div class="flex justify-between pb-2 border-b border-gray-200">
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select id="tabs" name="tabs"
                        class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option>Applied</option>

                        <option>Phone Screening</option>

                        <option selected>Interview</option>

                        <option>Offer</option>

                        <option>Disqualified</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <div>
                        <nav class="flex -mb-px space-x-4" aria-label="Tabs">

                            <a href="?"
                                class="@if ($filter == '') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                View All
                                <span
                                    class="@if ($filter == '') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block">{{ $counts['total'] }}</span>
                            </a>

                            @if(Auth::user()->isAdmin())
                            <a href="?filter=published"
                                class="@if ($filter == 'published') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                Published
                                <span
                                    class="@if ($filter == 'published') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block">{{ $counts['published'] }}</span>
                            </a>

                            <a href="?filter=draft"
                                class="@if ($filter == 'draft') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                Drafts
                                <span
                                    class="@if ($filter == 'draft') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block">{{ $counts['draft'] }}</span>
                            </a>

                            <a href="?filter=deleted"
                                class="@if ($filter == 'deleted') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                Deleted
                                <span
                                    class="@if ($filter == 'deleted') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block">{{ $counts['deleted'] }}</span>
                            </a>

                            <a href="?filter=template"
                                class="@if ($filter == 'template') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                Template
                                <span
                                    class="@if ($filter == 'template') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block">0</span>
                            </a>
                            @endif
                        </nav>
                    </div>
                </div>
                <div class="hidden gap-2 lg:flex">
                    <select class="text-sm border border-gray-200 rounded-md">
                        <option value="">Filter by Author</option>
                    </select>
                    <select wire:model="category_id" class="w-48 text-sm border border-gray-200 rounded-md">
                        <option value="">Filter by category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </section>

        <section class="mt-8 text-darkgreen">
            <div class="grid gap-6 lg:grid-cols-3">
                @foreach($courses as $course)
                <div class="flex flex-col p-4 bg-white border rounded-md shadow-md">
                    <div>
                        @if($course->icon == 'lightning')
                        <x-heroicon-s-lightning-bolt class="w-10 h-10 text-gray-600"/>
                        @else
                        <x-heroicon-s-academic-cap class="w-10 h-10 text-gray-600"/>
                        @endif
                    </div>
                    <p class="mt-1 text-orange-600">Course</p>
                    <h3 class="mt-2 text-lg font-bold">
                        <a href="{{ route('courses.show', [$course]) }}">
                        {{ $course->title }}
                        </a>
                    </h3>
                    <div class="text-gray-600">{{ Str::limit($course->description, 100) }}</div>
                    <div class="flex items-end justify-between flex-grow w-full mt-4">
                        <div class="flex gap-3">
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-template class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm">{{ $course->modules()->count() }} modules</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-clock class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm">{{ Carbon\Carbon::parse($course->estimated_time)->format('H:i') }} minutes</span>
                            </div>
                        </div>
                        <x-dropdown>
                            <x-slot name="button">
                                <button>
                                    <x-heroicon-s-dots-vertical class="w-4 h-4 text-gray-400"/>
                                </button>
                            </x-slot>
                            <div>
                                <a href="{{ route('courses.show', $course->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 group" role="menuitem"
                                    tabindex="-1" id="menu-item-0">
                                    <x-heroicon-s-play  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                    Play
                                </a>
                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('courses.edit', $course->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 group" role="menuitem"
                                    tabindex="-1" id="menu-item-0">
                                    <x-heroicon-s-pencil  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                    Edit Details
                                </a>
                                <a href="{{ route('courses.contents', $course->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 group" role="menuitem"
                                    tabindex="-1" id="menu-item-0">
                                    <x-heroicon-s-view-list  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                    Edit Contents
                                </a>
                                @endif
                            </div>
                        </x-dropdown>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
