<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show() {
        return view('pelanggan.lihatProfil', ['user' => Auth::user()]);
    }

    public function edit() {
    $user = Auth::user();
    $profile = $user->profile;
    // $layout = $user->role === 'penjahit' ? 'layouts.appPenjahit' : 'layouts.appPelanggan';

    return view('pelanggan.edit', compact('user', 'profile'));
}

    public function update(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        [
            'phone' => $request->phone,
            'address' => $request->address,
        ]
    );

    return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui');
    }

    public function passwordForm() {
        // $layout = $user->role === 'penjahit' ? 'layouts.appPenjahit' : 'layouts.appPelanggan';
        return view('pelanggan.editPW');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah');
    }
}
