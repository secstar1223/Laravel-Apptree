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
            preview: null,
            uploadFile(image){
                var url = URL.createObjectURL(image);
                this.preview = url;

                @this.upload('state', image, (uploadedFilename) => {
                    // Success callback.
                }, () => {
                    // Error callback.
                }, (event) => {
                    // Progress callback.
                    // event.detail.progress contains a number between 1 and 100 as the upload progresses.
                })
            }
         }">
        <p class="text-sm font-light text-gray-600">This photo will be displayed as the cover image</p>
        <label class="block p-4 bg-white border rounded-sm cursor-pointer">
            <input type="file" accept="image/png, image/gif, image/jpeg" class="hidden" 
            x-on:change="uploadFile($event.target.files[0])" x-model="state">
            <div x-show="preview" x-cloak class="flex justify-center py-4 mb-2 bg-gray-100 rounded-sm">
                <img :src="preview" class="h-36">
            </div>
            <div class="flex flex-col items-center justify-center">
                <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full">
                    <x-heroicon-o-cloud-upload class="w-6 h-6 text-gray-700"/>
                </div>
                <p class="mt-2"><strong class="text-orange-400">Click to upload </strong><span>or drag and drop</span></p>
                <p class="mt-1 text-sm font-light text-gray-500">PNG or JPG (max. 800x400px)</p>
            </div>
        </label>
    </div>
</x-dynamic-component>
