<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ 
            state: $wire.entangle('{{ $getStatePath() }}').defer, 
            isOpen: false,
            setState($state){
                this.state = $state;
                this.isOpen = false;
            }
        }" 
        x-on:click.away="isOpen = false"
        class="relative">
        <div class="relative h-10 px-2 pt-2 bg-white border border-gray-300 rounded-md">
            <div class="flex justify-center">
                <div class="-ml-5">
                    <x-heroicon-s-lightning-bolt class="w-6 h-6 text-darkgreen" x-show="state == 'lightning'"/>
                    <x-heroicon-s-academic-cap class="w-6 h-6 text-darkgreen" x-show="state == 'education'"/>
                </div>
            </div>
            <div class="absolute top-2 right-2">
                <button type="button" class="px-1 bg-gray-100 rounded-md " x-on:click="isOpen = !isOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                      </svg>
                </button>
            </div>
        </div>
        <div x-cloak x-show="isOpen" class="absolute left-0 right-0 z-10 w-64 h-16 bg-white border border-gray-300 rounded-md shadow-sm">
            <div class="grid grid-cols-5 gap-6 p-3">
                <button type="button" x-on:click="setState('lightning')">
                    <x-heroicon-s-lightning-bolt class="w-6 h-6 text-gray-500 hover:text-darkgreen"/>
                </button>
                <button type="button" x-on:click="setState('education')">
                    <x-heroicon-s-academic-cap class="w-6 h-6 text-gray-500 hover:text-darkgreen"/>
                </button>
            </div>
        </div>
    </div>
</x-dynamic-component>
