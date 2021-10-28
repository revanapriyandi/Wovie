<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Charts\UserChart;
use App\Actions\DeleteUser;
use Illuminate\Http\Request;
use App\Contracts\DeletesUsers;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Actions\ConfirmPassword;
use Illuminate\Validation\ValidationException;
use App\Actions\Fortify\UpdateUserProfileInformation;

class UserController extends Controller
{
    public function index(UserChart $chart, Request $request)
    {
        $request->validate(['term' => 'string']);

        $users = User::when($request->term, function ($query, $term) {
            $query->where('name', 'LIKE', '%' . $term . '%')->orWhere('email', 'LIKE', '%' . $term . '%');
        })->latest()->paginate(10);

        $userActive = User::where('status', true)
            ->where('role', false)
            ->count();

        $userInActive = User::where('status', false)
            ->where('role', false)
            ->count();

        $premiumUser = User::where('status', true)
            ->where('role', false)
            ->where('is_premium', true)
            ->count();

        $verifiedUser = User::where('status', true)
            ->where('role', false)
            ->where('email_verified_at', '!=', null)
            ->count();

        return Inertia::render('Admin/User/Report', [
            'users' => $users,
            'userActive' => $userActive,
            'premiumUser' => $premiumUser,
            'userInActive' => $userInActive,
            'verifiedUser' => $verifiedUser,
            'chart' => $chart->build()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/User/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_no' => 'required',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password' => bcrypt($request->password),
            'role' => false,
            'status' => true
        ]);

        return back()->with('success', 'User created successfully');
    }

    function edit($id)
    {
        return Inertia::render('Admin/User/Edit', [
            'user' => User::findOrFail($id)
        ]);
    }

    public function update(UpdateUserProfileInformation $updater, $id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($request->photo) {
            $user->updateProfilePhoto($request->photo);
        }
        $updater->update($user, $request->all());

        return back()->with('success', 'User updated successfully');
    }

    public function updatePassword(Request $request, $id, ResetUserPassword $reset)
    {
        $reset->reset(User::findOrFail($id), $request->all());

        return back()->with('success', 'User Password updated successfully');
    }

    public function status($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status ? false : true;
        $user->update();

        return back()->with('success', 'User status updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        app(DeleteUser::class)->delete($user->fresh());


        return back()->with('success', 'User Deleted successfully');
    }
}
