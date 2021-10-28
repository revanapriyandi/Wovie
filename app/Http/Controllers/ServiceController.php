<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Settings/Service', [
            'services' => Services::when($request->term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%')->orWhere('description', 'LIKE', '%' . $term . '%');
            })->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);

        Services::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Service created successfully.');
    }

    public function destroy($id)
    {
        Services::findOrFail($id)->delete();

        return back()->with('success', 'Service deleted successfully.');
    }
}
