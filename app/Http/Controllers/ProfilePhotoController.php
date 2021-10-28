<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilePhotoController extends Controller
{
    public function destroy($id)
    {
        User::findOrFail($id)->deleteProfilePhoto();

        return back(303)->with('status', 'profile-photo-deleted');
    }
}
