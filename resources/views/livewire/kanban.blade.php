<div>
    <div x-data wire:ignore class="md:flex overflow-x-auto overflow-y-hidden gap-4 pb-4">
        @foreach($statuses as $status)
            @include(static::$statusView)
        @endforeach

        <div wire:ignore>
            @include(static::$scriptsView)
        </div>
    </div>

    @unless($disableEditModal)
        <x-filament-kanban::edit-record-modal/>
    @endunless
</div>
