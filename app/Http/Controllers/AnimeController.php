<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Genres;
use App\Models\Country;
use App\Models\Producer;
use App\Models\PostGenre;
use App\Charts\AnimeChart;
use App\Models\PostDownload;
use App\Models\PostEpisode;
use App\Models\PostVideo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index(Request $request, AnimeChart $chart)
    {
        return Inertia::render('Admin/Anime/Index', [
            'animes' => Post::when($request->term, function ($query, $term) {
                $query->where('title', 'LIKE', '%' . $term . '%')->orWhere('title_sub', 'LIKE', '%' . $term . '%')
                    ->orWhere('slug', 'LIKE', '%' . $term . '%');
            })->latest()->paginate(10),
            'allAnimes' => Post::where('type', '1')->orWhere('type', '2')->count(),
            'tv' => Post::where('type', '1')->count(),
            'movie' => Post::where('type', '2')->count(),
            'member_only' => Post::where('type', 1)->where('member_only', true)->count(),
            'chart' => $chart->build()
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Admin/Anime/Create', [
            'genres' => Genres::all(),
            'countrys' => Country::all(),
            'producers' => Producer::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_sub' => ['required', 'string', 'max:255'],
            'genres' => 'required',
            'description' => 'required',
            'country_id' => ['required', 'integer'],
            'release_date' => ['required', 'date'],
            'duration' => ['required', 'string'],
            'trailer' => ['required', 'string'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'score' => 'required',
            'producer_id' => ['required', 'integer'],
            'musim' => ['required', 'integer'],
            'episode' => ['required', 'integer'],
            'status' => ['required', 'integer'],
        ]);

        $post = new Post();
        $post->type = $request->isMovie ? '2' : '1';
        $post->title = $request->title;
        $post->title_sub = $request->title_sub;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->country_id = $request->country_id;
        $post->released = $request->release_date;
        $post->year = date('Y', strtotime($request->release_date));
        $post->duration = $request->duration;
        $post->trailer = $request->trailer;
        $post->musim = $request->musim;
        $post->episode = $request->episode;
        $post->score = $request->score;
        $post->producer_id = $request->producer_id;

        $post->status = $request->status;
        $post->private = $request->active;
        $post->member_only = $request->memberOnly;
        $post->featured = $request->featured;
        $post->data = json_encode([
            'tags' => $request->tags
        ]);

        if ($request->image) {
            $post->updateImagePost($request->image);
        }
        $post->save();

        foreach ($request->genres as $genre) {
            PostGenre::create([
                'genre_id' => $genre,
                'content_id' => $post->id
            ]);
        }

        return redirect()->route('anime.edit', $post->id)->with('success', 'Anime add succesfully');
    }

    public function edit(Request $request, $id)
    {
        $anime = Post::findOrFail($id);

        return Inertia::render('Admin/Anime/Edit', [
            'anime' => $anime,
            'anime_genre' => Arr::pluck($anime->genre, 'id'),
            'genres' => Genres::all(),
            'countrys' => Country::all(),
            'producers' => Producer::all(),
            'animeData' => json_decode($anime->data),
            'episodes' => PostEpisode::with('anime')->where('content_id', $id)->when($request->term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%')->orWhere('description', 'LIKE', '%' . $term . '%');
            })->latest()->paginate(10),
            'animeId' => $id,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_sub' => ['required', 'string', 'max:255'],
            'genres' => 'required',
            'description' => 'required',
            'country_id' => ['required', 'integer'],
            'release_date' => ['required', 'date'],
            'duration' => ['required', 'string'],
            'trailer' => ['required', 'string'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'score' => 'required',
            'producer_id' => ['required', 'integer'],
            'musim' => ['required', 'integer'],
            'episode' => ['required', 'integer'],
            'status' => ['required', 'integer'],
        ]);

        $post = Post::findOrFail($id);

        PostGenre::where('content_id', $post->id)->delete();
        foreach (array_unique(array_merge(Arr::pluck($post->genre, 'id'), $request->genres)) as $genre) {

            PostGenre::updateOrCreate([
                'genre_id' => $genre,
                'content_id' => $post->id
            ], [
                'genre_id' => $genre,
                'content_id' => $post->id
            ]);
        }

        $post->type = $request->isMovie ? '2' : '1';
        $post->title = $request->title;
        $post->title_sub = $request->title_sub;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->country_id = $request->country_id;
        $post->released = $request->release_date;
        $post->year = date('Y', strtotime($request->release_date));
        $post->duration = $request->duration;
        $post->trailer = $request->trailer;
        $post->musim = $request->musim;
        $post->episode = $request->episode;
        $post->score = $request->score;
        $post->producer_id = $request->producer_id;

        $post->status = $request->status;
        $post->private = $request->active;
        $post->member_only = $request->memberOnly;
        $post->featured = $request->featured;
        $post->data = json_encode([
            'tags' => $request->tags
        ]);

        if ($request->image) {
            $post->updateImagePost($request->image);
        }
        $post->update();

        return back()->with('success', 'Anime update succesfully');
    }

    public function destroy($id)
    {
        $data = Post::findOrFail($id);
        PostEpisode::where('content_id', $id)->delete();
        PostDownload::where('content_id', $id)->delete();
        PostVideo::where('content_id', $id)->delete();
        PostGenre::where('content_id', $id)->delete();
        $data->deleteImagePost();
        $data->delete();

        return back()->with('success', 'Anime deleted succesfully');
    }
}
