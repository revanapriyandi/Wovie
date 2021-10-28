<?php

namespace App\Charts;

use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class UserChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        $freeUser = User::where('status', true)
            ->where('role', false)
            ->where('is_premium', false)
            ->count();
        $userInActive = User::where('status', false)
            ->where('role', false)
            ->count();
        $premiumUser = User::where('status', true)
            ->where('role', false)
            ->where('is_premium', true)
            ->count();

        $verifiedUser = User::where('status', true)
            ->where('role', false)
            ->where('email_verified_at', '!=', null)
            ->count();

        return $this->chart->pieChart()
            ->setTitle('Users Chart.')
            ->setSubtitle('Perbandingan Users Wovie')
            ->addData([$premiumUser, $freeUser, $userInActive, $verifiedUser])
            ->setLabels(['Premium', 'Free', 'InActive', 'Verified'])
            ->toVue();
    }
}
