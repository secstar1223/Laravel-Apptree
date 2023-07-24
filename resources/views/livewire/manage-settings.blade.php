<div>

    <header class="flex justify-between px-16 py-6 bg-white">
        <div>
            <h1 class="text-3xl font-bold leading-7 text-darkgreen sm:leading-9">Settings</h1>
        </div>
        <div>

        </div>
    </header>

    <div class="px-16 py-12 bg-gray-100">
        <div class="grid grid-cols-3 gap-8">
            <section class="col-span-3">
                <h3 class="text-xl font-bold text-emerald-800">Course Library Management</h3>
                <p class="text-gray-700">Select the Course Libraries you want to be visible in your accounts template library</p>

                <div class="p-6 mt-8 bg-white border rounded-md">
                    {{ $this->libraryForm }}
                </div>
            </section>

            <section class="col-span-3">
                <h3 class="text-xl font-bold text-emerald-800">Allow Full Content Library Access</h3>
                <p class="text-gray-700">Select the Course Libraries you want to be visible in your accounts template library</p>

                <div class="p-6 mt-8 bg-white border rounded-md">
                    {{ $this->permissionForm }}
                </div>
            </section>

            <div class="col-span-3 mb-8 border-t border-dashed"></div>

            <section class="col-span-3">
                @foreach($settings as $config)
                <div class="py-6 border-b">
                    @livewire('settings.setting-item', ['id' => $config->id] , key('setting-' . $config->id . '-' . time()))
                </div>
                @endforeach
            </section>
        </div>
    </div>
</div>
