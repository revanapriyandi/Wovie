<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Genres;
use App\Models\PostDownload;
use App\Models\Producer;
use App\Models\PostGenre;
use App\Models\PostVideo;
use App\Models\PostEpisode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {

        return Inertia::render('Admin/Dashboard');
    }

    protected function statusAnime($d)
    {
        if ($d === 'Ongoing') {
            return '1';
        }

        return $d === 'Completed' ? '2' : '3';
    }

    protected function MusimAnime($tgl)
    {
        $date = date('m', strtotime($tgl));

        switch ($date) {
            case '01':
                return '4';
                break;
            case '02':
                return '4';
                break;
            case '03':
                return '1';
                break;
            case '04':
                return '1';
                break;
            case '06':
                return '2';
                break;
            case '07':
                return '2';
                break;
            case '08':
                return '2';
                break;
            case '09':
                return '3';
                break;
            case '10':
                return '3';
                break;
            case '11':
                return '3';
                break;
            case '12':
                return '4';
                break;

            default:
                return null;
                break;
        }
    }
}
