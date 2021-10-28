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
        $compl = Http::get('http://localhost:3000/api/complete/page/37')->json();
        foreach ($compl['animeList'] as $comp) {
            $anime = Http::get('http://localhost:3000/api/anime/' . $comp['id'])->json();

            $postC = Post::where('title', $anime['title'])->first();

            $produ = Producer::where('name', 'LIKE', '%' .  $anime['studio'] . '%')->first();

            if (!$produ) {
                Producer::create(['name' => $anime['studio']])->save();
            }

            if (!$postC) {
                $post = Post::create([
                    'type' => $anime['type'] == "TV" ? "1" : "2",
                    'title' => $anime['title'],
                    'slug' => Str::slug($anime['title']),
                    'title_sub' => $anime['japanase'],
                    'cover_url' => $anime['thumb'],
                    'description' => $anime['synopsis'],
                    'producer_id' => $produ->id ?? null,
                    'episode' => $anime['total_episode'],
                    'country_id' => '2',
                    'duration' =>  $anime['duration'],
                    'year' => date('Y', strtotime($anime['release_date'])),
                    'score' => $anime['score'],
                    'musim' => $this->MusimAnime($anime['release_date']),
                    'released' => date('Y-m-d', strtotime($anime['release_date'])),
                    'status' => $this->statusAnime($anime['status']),
                ]);
            }

            foreach ($anime['genre_list'] as $gen) {
                $genres = Genres::where('name', 'LIKE', '%' . $gen['genre_name'] . '%')->first();

                if (!$genres) {
                    Genres::create(['name' => $gen['genre_name'], 'slug' => Str::slug($gen['genre_name']), 'type' => '0'])->save();
                }

                $genre = PostGenre::create([
                    'genre_id' => $genres->id ?? null,
                    'content_id' => $post->id ?? $postC->id,
                ]);
            }

            foreach ($anime['episode_list'] as $epi) {
                $episode = Http::get('http://localhost:3000/api/eps/' . explode('https://otakudesu.vip/', $epi['id'])[1])->json();

                $episodeC = PostEpisode::where('name', 'LIKE', '%' . $episode['title'] . '%')->first();

                if (!$episodeC) {
                    $postEps = PostEpisode::create([
                        'name' => $episode['title'],
                        'content_id' => $post->id,
                    ]);
                }

                $postVidC = PostVideo::where('name', $episode['title'] . ' - 360p')->first();

                if (!$postVidC) {
                    $postVideo = PostVideo::create([
                        'content_id' => $post->id,
                        'episode_id' => $postEps->id,
                        'name' => $episode['title'] . ' - 360p',
                        'language_id' => '1',
                        'quality' => '360p',
                        'embed' => $episode['link_stream'],
                    ]);
                }

                foreach ($episode['quality'] as $qua) {
                    $postDownC = PostDownload::where('name', $episode['title'] . ' - ' . $qua['quality'])->first();

                    if (!$postDownC) {
                        $postDownload = PostDownload::create([
                            'content_id' => $post->id,
                            'video_id' => $postVideo->id,
                            'episode_id' => $postEps->id,
                            'name' => $episode['title'] . ' - ' . $qua['quality'],
                            'quality' => $qua['quality'],
                            'language_id' => '1',
                            'links' => json_encode($qua['download_links']),
                        ]);
                    }
                }
            }
        }

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
