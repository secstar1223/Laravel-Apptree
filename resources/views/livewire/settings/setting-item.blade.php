<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-6 gap-6 settings-page">
            <div class="col-span-2">
                <h3 class="font-bold text-darkgreen">{{ $setting->key }}</h3>
                <div class="text-sm text-gray-700">{!! $setting->description !!}</div>
            </div>
            <div class="col-span-3">
                {{ $this->form }}
            </div>
            <div class="self-center">
                <button type="submit" class="btn-primary btn-sm">Save</button>
            </div>
        </div>
    </form>
</div>
