<div class="bg-gray-100">
    <header class="flex justify-between px-16 py-6 bg-white">
        <h1 class="text-3xl font-bold leading-7 text-darkgreen sm:leading-9">Add New Pathway</h1>
    </header>
    
    <div class="px-16">
    
        <div class="py-8 bg-gray-100 text-darkgreen">
            <nav class="flex items-center space-x-4" aria-label="Tabs">
                <a href="{{ route('pathway.builder', ['id' => $pathway->id]) }}" class="flex items-center">
                    <span class=" px-0.5 py-0.5 text-sm font-normal rounded-sm bg-green-500/70">
                        <x-heroicon-s-check class="w-4 h-4 text-white"/>
                    </span>
                    <span class="ml-2 font-normal text-gray-500 hover:text-darkgreen">Overview</span>
                </a>
    
                <div>
                    <span class="px-1.5 py-0.5 text-white rounded-md bg-darkgreen text-xs font-bold">2</span>
                    <span class="ml-2 font-semibold text-darkgreen">Select  Courses</span>
                </div>
            </nav>
            <section class="mt-8">
                {{ $this->table }}
            </section>
        </div>
    </div>
    
</div>