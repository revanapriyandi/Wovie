<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Settings/Country', [
            'countrys' => Country::when($request->term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%');
            })->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lang' => 'required|string'
        ]);

        Country::create([
            'name' => $request->name,
            'lang' => $request->lang,
        ]);

        return back()->with('success', 'Country created successfully.');
    }

    public function destroy($id)
    {
        Country::findOrFail($id)->delete();

        return back()->with('success', 'Country deleted successfully.');
    }
}
