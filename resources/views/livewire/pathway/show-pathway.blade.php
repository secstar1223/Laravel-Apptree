<div>
    <div class="px-16 py-12 bg-gray-100">

        <div class="mt-8">
            <section class="w-3/4">
                <div class="grid grid-cols-3 gap-6 p-8 bg-white border shadow-lg">
                    <div class="col-span-2 pr-4 border-r rounded-md ">
                        <div class="inline-block p-4 bg-gray-100 rounded-md">
                            <x-heroicon-s-template class="w-10 h-10 text-gray-600"/>
                        </div>
        
                        <h1 class="mt-8 text-3xl font-bold text-darkgreen">{{ $pathway->title }}</h1>
                        <div class="mt-4 font-light text-gray-600">{!! $pathway->description !!}</div>
                        <div class="flex gap-6 mt-8">
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-template class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm text-darkgreen">{{ $pathway->courses()->count() }} courses</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-clock class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm text-darkgreen">{{ $pathway->estimated_time }} minutes</span>
                            </div>
                            @if($pathway->offer_certificate)
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-clipboard-check class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm text-darkgreen">Certificate of Completion</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col justify-end">
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-darkgreen">Goals</h4>
                            <div class="flex flex-col mt-4">
                                <div class="flex items-center w-full">
                                    <x-heroicon-s-check class="flex-shrink-0 w-5 h-5 mr-2 text-orange-400"/>
                                    <span class="text-sm text-gray-600">{{ $pathway->goal?->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" class="btn-primary btn-sm">Start Pathway</button>
                        </div>
                    </div>
                </div>
    
                <div class="relative mt-12">
                    <div class="absolute top-0 bottom-0 translate-x-1/2 border-r-2 border-gray-300 left-1/2"></div>
                    <div class="space-y-6">
                    </div>
                </div>
            </section>

            <section class="mt-8">
				<div class="flex justify-between pb-6 border-b-2 border-gray-300">
					<h3 class="text-xl font-bold text-darkgreen">Courses You Will Take</h3>
				</div>
				<div class="grid grid-cols-2 gap-6 mt-8 lg:grid-cols-3">
					@foreach($pathway->courses as $availableCourse)
					<div class="flex flex-col p-4 bg-white border rounded-md shadow-md">
						<div>
							@if($availableCourse->icon == 'lightning')
							<x-heroicon-s-lightning-bolt class="w-10 h-10 text-gray-600"/>
							@else
							<x-heroicon-s-academic-cap class="w-10 h-10 text-gray-600"/>
							@endif
						</div>
						<p class="mt-1 text-orange-600">Course</p>
						<h3 class="mt-2 text-lg font-bold">{{ $availableCourse->title }}</h3>
						<div class="text-gray-600">{{ Str::limit($availableCourse->description, 100) }}</div>
						<div class="flex items-end justify-between flex-grow w-full mt-4">
							<div class="flex gap-3">
								<div class="flex items-center gap-1">
									<x-heroicon-o-template class="flex-shrink-0 w-4 h-4 text-gray-400"/>
									<span class="text-sm">{{ $availableCourse->modules()->count() }} modules</span>
								</div>
								<div class="items-center hidden gap-1 md:flex">
									<x-heroicon-o-clock class="w-4 h-4 text-gray-400"/>
									<span class="text-sm">{{ $availableCourse->estimated_time }} minutes</span>
								</div>
							</div>
							<x-dropdown>
								<x-slot name="button">
									<button>
										<x-heroicon-s-dots-vertical class="w-4 h-4 text-gray-400"/>
									</button>
								</x-slot>
								<div>
									<a href="{{ route('courses.show', $availableCourse->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 group" role="menuitem"
										tabindex="-1" id="menu-item-0">
										<x-heroicon-s-play  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
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
