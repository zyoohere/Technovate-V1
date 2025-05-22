<x-filament::widget>
    <x-filament::card>
        <h3 class="text-lg font-bold mb-4">🔥 Artikel Terpopuler</h3>
        <ul>
            @forelse (($artikels ?? []) as $artikel)
                <li class="mb-3">
                    <div class="font-medium">{{ $artikel->title }}</div>
                    <div class="text-sm text-gray-500">{{ $artikel->views_count }} views</div>
                </li>
            @empty
                <li>Tidak ada data.</li>
            @endforelse
        </ul>
    </x-filament::card>
</x-filament::widget>
