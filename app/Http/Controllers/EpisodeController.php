<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Country;
use App\Models\PostEpisode;
use App\Models\PostVideo;
use App\Models\Services;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function index(Request $request, $id)
    {
        return Inertia::render('Admin/Anime/Episode/Index', [
            'episodes' => PostEpisode::with('anime')->where('content_id', $id)->when($request->term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%')->orWhere('description', 'LIKE', '%' . $term . '%');
            })->latest()->paginate(10),
            'animeId' => $id,
        ]);
    }

    public function edit($id)
    {
        return Inertia::render('Admin/Anime/Episode/Edit', [
            'episode' => PostEpisode::with('anime')->findOrFail($id),
            'langs' => Country::all(),
            'services' => Services::all(),
            'videos' => PostVideo::with(['Lang', 'Service'])->where('episode_id', $id)->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'episode' => ['required', 'numeric', 'min:1'],
            'overview' => 'required',
            'active' => ['required', 'boolean'],
            'featured' => ['required', 'boolean'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $eps = PostEpisode::findOrFail($id);
        $eps->name = $request->episode;
        $eps->description = $request->overview;
        $eps->published = $request->active;
        $eps->featured = $request->featured;
        $eps->slider = $request->featured;

        if ($request->image) {
            $eps->updateImagePost($request->image);
        }
        $eps->update();

        return back()->with('success', 'Episode updated successfully');
    }

    public function create($id)
    {
        return Inertia::render('Admin/Anime/Episode/Create', [
            'animeId' => $id,
        ]);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'episode' => ['required', 'numeric', 'min:1'],
            'overview' => 'required',
            'active' => ['required', 'boolean'],
            'featured' => ['required', 'boolean'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $eps = new PostEpisode();
        $eps->content_id = $id;
        $eps->name = $request->episode;
        $eps->description = $request->overview;
        $eps->published = $request->active;
        $eps->featured = $request->featured;
        $eps->slider = $request->featured;

        if ($request->image) {
            $eps->updateImagePost($request->image);
        }
        $eps->save();

        return redirect()->route('episode.edit', $eps->id)->with('success', 'Episode created successfully');
    }

    public function destroy($id)
    {
        PostEpisode::findOrFail($id)->delete();

        PostVideo::where('episode_id', $id)->delete();

        return back()->with('success', 'Episode deleted successfully');
    }
}
