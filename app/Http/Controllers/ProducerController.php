<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProducerController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Settings/Producer', [
            'producers' => Producer::when($request->term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%');
            })->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $prod = Producer::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->photo) {
            $prod->ImageProducer($request->photo);
        }

        return back()->with('success', 'Producer created successfully.');
    }

    public function destroy($id)
    {
        $prod = Producer::findOrFail($id);
        $prod->deleteImage();
        $prod->delete();

        return back()->with('success', 'Producer deleted successfully.');
    }
}
