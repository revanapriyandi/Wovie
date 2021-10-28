<?php

namespace App\Charts;

use App\Models\Post;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AnimeChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        return $this->chart->pieChart()
            ->setTitle('Anime Chart.')
            ->setSubtitle('All anime and movie')
            ->addData([Post::where('type', '1')->count(), Post::where('type', '2')->count(), Post::where('type', '1')->where('member_only', true)->count()])
            ->setLabels(['Anime TV', 'Anime Movie', 'Member Only'])
            ->toVue();
    }
}
