<?php

namespace App\Http\Controllers;

use App\Models\PostDownload;
use App\Models\PostVideo;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request, $animeId, $eps)
    {
        $request->validate([
            'language_id' => ['required', 'integer'],
            'quality' => ['string', 'max:50'],
            'video' => ['required', 'url'],
            'vp' => 'boolean',
            'download' => 'url',
        ]);

        $post = PostVideo::create([
            'content_id' => $animeId,
            'episode_id' => $eps,
            'name' => $request->title,
            'language_id' => $request->language_id,
            'service_id' => $request->service_id,
            'quality' => $request->quality,
            'embed' => !$request->vp ? $request->video : null,
            'player' => $request->vp ? $request->video : null,
        ]);

        PostDownload::create([
            'content_id' => $animeId,
            'episode_id' => $eps,
            'video_id' => $post->id,
            'name' => $request->title,
            'language_id' => $request->language_id,
            'service_id' => $request->service_id2,
            'quality' => $request->quality,
            'links' => $request->download,
        ]);

        return back()->with('success', 'Video added successfully');
    }

    public function destroy($id)
    {
        PostVideo::findOrFail($id)->delete();
        PostDownload::where('video_id', $id)->delete();

        return back()->with('success', 'Video deleted successfully');
    }
}
