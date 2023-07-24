@props(['ref'])

<x-base-modal ref="{{ $ref }}" class="lg:max-w-2xl">
    {{ $slot }}
</x-base-modal>