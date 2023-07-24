<div>
    <div class="px-16 py-12 bg-gray-100">

        <div class="grid grid-cols-3 gap-8 mt-8">
            <section class="col-span-2">
                <div class="grid grid-cols-3 gap-6 p-8 bg-white border shadow-lg">
                    <div class="col-span-2 pr-4 border-r rounded-md ">
                        <div class="inline-block p-4 bg-gray-100 rounded-md">
                            <x-heroicon-s-academic-cap class="w-10 h-10 text-gray-600"/>
                        </div>
        
                        <h1 class="mt-8 text-3xl font-bold text-darkgreen">{{ $course->title }}</h1>
                        <div class="mt-4 font-light text-gray-600">{!! $course->description !!}</div>
                        <div class="flex gap-3 mt-8">
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-template class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm">{{ $course->modules()->count() }} modules</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-clock class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm">{{ Carbon\Carbon::parse($course->estimated_time)->format('H:i') }} minutes</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center self-center justify-center">
                        <button type="button" wire:click="start" class="duration-300 ease-in-out scale-90 bg-white rounded-full hover:scale-100">
                            <x-heroicon-s-play class="w-32 h-32 text-darkgreen"/>
                        </button>
                        @if($enrollment_record)
                            @if($enrollment_record->isComplete())
                            <p class="mt-2">Retake Course</p>
                            @else
                            <p class="mt-2">Continue</p>
                            @endif
                        @else
                        <p class="mt-2">Start learning</p>
                        @endif
                    </div>
                </div>
    
                <div class="relative mt-12">
                    <div class="absolute top-0 bottom-0 translate-x-1/2 border-r-2 border-gray-300 left-1/2"></div>
                    <div class="space-y-6">
                        @foreach($modules as $module)
                        <div wire:key="module-{{ $module['id'] }}"
                            class="relative z-20 p-4 bg-white border rounded-md shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <x-heroicon-o-template class="w-10 h-10 text-gray-400"/>
                                    </div>
                                    <p class="ml-4 font-bold">{{ $module['title'] }}</p>
                                </div>
                                @if($module['items_count'])
                                <div class="flex items-center gap-2 pr-4">
                                    <span>{{ $module['completed_count']  .' / ' .$module['items_count'] }}</span>
                                    @if( ($module['completed_count'] / $module['items_count']) == 1)
                                    <x-heroicon-s-check-circle class="w-5 h-5 text-blue-700"/>
                                    @else
                                    <x-heroicon-s-check-circle class="w-5 h-5 text-gray-400"/>
                                    @endif
                                </div>
                                @else
                                <div class="text-sm text-gray-500 underline">No items available.</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @if($enrollment_record)
            <section>
                <div class="border rounded-md bg-yellow-500/30">
                    <div class="px-4 py-8">
                        <img src="{{ asset('img/badge.png') }}" class="w-auto h-32 mx-auto">
                    </div>
                    <div class="px-4 py-4 text-sm text-gray-700">
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-bold text-gray-900">
                                Last Taken
                            </dt>
                            <dd class="mt-1 text-sm text-gray-600 underline sm:col-span-3 lg:col-span-2 sm:mt-0">
                                {{ $enrollment_record->created_at }}
                            </dd>
                        </div>
                        <p>Score: </p>
                        <p>Remarks:</p>
                        <p>Certificate:</p>
                    </div>
                </div>
            </section>
            @endif
        </div>
        
    </div>
</div>
