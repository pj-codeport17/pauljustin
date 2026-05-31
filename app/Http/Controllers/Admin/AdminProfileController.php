<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller {

    public function show() {
        return view('admin.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request) {
        $user  = auth()->user();
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];
        if ($request->filled('password')) $rules['password'] = 'min:8|confirmed';
        $data = $request->validate($rules);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        if ($request->filled('password')) $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated!');
    }

    public function updateAvatar(Request $request) {
        $request->validate(['avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048']);
        $user = auth()->user();

        if ($user->avatar) {
            $old = public_path('uploads/avatars/' . $user->avatar);
            if (file_exists($old)) unlink($old);
        }

        $file = $request->file('avatar');
        $fn   = 'av_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/avatars'), $fn);
        $user->avatar = $fn;
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile picture updated!');
    }
}
