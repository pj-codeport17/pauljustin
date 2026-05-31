<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller {

    public function show() {
        $user  = auth()->user();
        $stats = Anime::where('user_id', $user->id)->selectRaw("
            COUNT(*) as total,
            SUM(status='completed') as completed,
            SUM(status='watching')  as watching,
            COALESCE(SUM(episodes_watched), 0) as eps
        ")->first();
        return view('user.profile', compact('user','stats'));
    }

    public function update(Request $request) {
        $user = auth()->user();

        $rules = [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'gender'  => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
        ];
        if ($request->filled('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $data = $request->validate($rules);

        $user->name    = $data['name'];
        $user->email   = $data['email'];
        $user->gender  = $data['gender']  ?? null;
        $user->address = $data['address'] ?? null;
        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated!');
    }

    public function updateAvatar(Request $request) {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        // Delete old avatar
        if ($user->avatar) {
            $oldPath = public_path('uploads/avatars/' . $user->avatar);
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $file     = $request->file('avatar');
        $filename = 'av_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/avatars'), $filename);

        $user->avatar = $filename;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile picture updated!');
    }
}
