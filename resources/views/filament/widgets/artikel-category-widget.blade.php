<x-filament::widget>
    <x-filament::card>
        {{ $this->table }}
    </x-filament::card>
</x-filament::widget><x-filament::widget>
    <x-filament::card>
        <x-slot name="header">
            <h2 class="text-xl font-bold">Artikel per Kategori</h2>
        </x-slot>

        {{ $this->table }}
    </x-filament::card>
</x-filament::widget>
