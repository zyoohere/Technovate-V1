<?php

namespace App\Filament\Widgets;

use App\Models\ArtikelView;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ArtikelTerpopuler extends ChartWidget
{
    protected static ?string $heading = '📊 Statistik View Artikel (7 Hari Terakhir)';
    // protected static string $view = 'filament.widgets.artikel-terpopuler';


    protected function getData(): array
    {
        $views = ArtikelView::select(DB::raw('DATE(viewed_at) as date'), DB::raw('count(*) as total'))
            ->where('viewed_at', '>=', now()->subDays(30)) // ambil 7 hari terakhir
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $views->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M Y'))->toArray();
        $data = $views->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total View',
                    'data' => $data,
                    'backgroundColor' => '#3b82f6', // Biru Filament
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // bisa diganti 'line' jika ingin garis
    }

    protected function getMaxHeight(): string
    {
        return '1000px';
    }
}
