@extends('layouts.app')

@section('content')
    <div>
        <header class="flex justify-between py-6 pl-4 bg-white lg:pl-16">
            <div>
                <h3 class="text-lg font-bold text-darkgreen lg:text-xl">Welcome back, {{ Auth()->user()->name }}</h3>
            </div>
        </header>

        <div>
            <div class="px-8 py-12 pl-4 space-y-8 bg-gray-100 lg:pl-16">
                @if (count($enrollments))
                    <section>
                        <div class="border-gray-300">
                            <h3 class="text-lg font-bold text-darkgreen lg:text-xl">Courses You're Taking</h3>
                        </div>
                        <div class="grid gap-6 mt-4 lg:grid-cols-3">
                            @foreach ($enrollments as $enrollment)
                                <div class="bg-white rounded-md shadow-sm">
                                    <div class="h-52 w-full rounded-t-md border bg-[url('http://marketplace.test/img/default.svg')] bg-cover bg-center"
                                        style="background-image: url({{ $enrollment->course?->image_url ?? asset('img/question.jpg') }})">
                                        <div
                                            class="flex items-center justify-center w-full h-full rounded-t-md bg-gray-500/40 backdrop-blur-lg">
                                            <img src="{{ $enrollment->course?->image_url ?? asset('img/question.jpg') }}"
                                                class="w-40 h-40 p-4 bg-white rounded-md">
                                        </div>
                                    </div>
                                    <div class="items-center justify-between p-4 lg:flex lg:p-6">
                                        <div>
                                            <h3 class="text-xl font-bold text-darkgreen">{{ $enrollment->course->title }}
                                            </h3>
                                            <div class="gap-3 mt-3 md:flex">
                                                <div class="flex items-center gap-1">
                                                    <x-heroicon-o-template class="w-4 h-4 text-gray-400" />
                                                    <span class="text-sm">{{ $enrollment->course->modules()->count() }}
                                                        modules</span>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <x-heroicon-o-clock class="w-4 h-4 text-gray-400" />
                                                    <span
                                                        class="text-sm">{{ Carbon\Carbon::parse($enrollment->course->estimated_time)->format('H:i') }}
                                                        minutes</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 md:mt-0">
                                            <a href="{{ route('courses.show', $enrollment->course->id) }}"
                                                class="btn-primary">Continue</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <section class="mt-8">
                    <div class="flex justify-between pb-6 border-b-2 border-gray-300">
                        <h3 class="text-xl font-bold text-darkgreen">Library</h3>
                        <a href="{{ url('courses') }}" class="inline-flex items-center text-darkgreen">More
                            <x-heroicon-s-chevron-right class="w-4 h-4" />
                        </a>
                    </div>
                    <div class="grid gap-6 mt-8 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($libraries as $availableCourse)
                            <div class="flex flex-col p-4 bg-white border rounded-md shadow-md">
                                <div>
                                    @if ($availableCourse->icon == 'lightning')
                                        <x-heroicon-s-lightning-bolt class="w-10 h-10 text-gray-600" />
                                    @else
                                        <x-heroicon-s-academic-cap class="w-10 h-10 text-gray-600" />
                                    @endif
                                </div>
                                <p class="mt-1 text-orange-600">Course</p>
                                <h3 class="mt-2 text-lg font-bold">
                                    <a href="{{ route('courses.show', [$availableCourse]) }}">
                                    {{ $availableCourse->title }}
                                    </a>
                                </h3>
                                <div class="text-gray-600">{{ Str::limit($availableCourse->description, 100) }}</div>
                                <div class="flex items-end justify-between flex-grow w-full mt-4">
                                    <div class="flex gap-3">
                                        <div class="flex items-center gap-1">
                                            <x-heroicon-o-template class="flex-shrink-0 w-4 h-4 text-gray-400" />
                                            <span class="text-sm">{{ $availableCourse->modules()->count() }} modules</span>
                                        </div>
                                        <div class="items-center hidden gap-1 md:flex">
                                            <x-heroicon-o-clock class="w-4 h-4 text-gray-400" />
                                            <span
                                                class="text-sm">{{ Carbon\Carbon::parse($availableCourse->estimated_time)->format('H:i') }}
                                                minutes</span>
                                        </div>
                                    </div>
                                    <x-dropdown>
                                        <x-slot name="button">
                                            <button>
                                                <x-heroicon-s-dots-vertical class="w-4 h-4 text-gray-400" />
                                            </button>
                                        </x-slot>
                                        <div>
                                            <a href="{{ route('courses.show', $availableCourse->id) }}"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 group"
                                                role="menuitem" tabindex="-1" id="menu-item-0">
                                                <x-heroicon-s-play
                                                    class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" />
                                                Play
                                            </a>
                                        </div>
                                    </x-dropdown>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>

    </div>
@endsection
