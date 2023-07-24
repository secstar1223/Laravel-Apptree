<form action="" wire:submit.prevent="submit">
    {{ $this->form }}

    <div class="flex items-center justify-between pt-4 mt-8 border-t">
        <p class="text-xl font-bold text-darkgreen">Add Content</p>
        <div class="flex gap-2">
            <button type="button" class="btn-light" x-on:click="$dispatch('closeparentmodal')">Cancel</button>
            <button type="submit" class="btn-primary btn-sm">Save</button>
        </div>
    </div>
</form>