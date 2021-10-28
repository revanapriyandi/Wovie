<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Genres;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Genres/Index', [
            'genres' => Genres::when($request->term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%');
            })->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Genres::create([
            'slug' => Str::slug($request->name),
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Genre created successfully.');
    }

    public function destroy($id)
    {
        Genres::findOrFail($id)->delete();

        return back()->with('success', 'Genre deleted successfully.');
    }
}
