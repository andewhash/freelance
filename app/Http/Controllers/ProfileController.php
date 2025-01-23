<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();
        $user->update($request->only('name', 'mobile', 'email', 'location'));
        return back();
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('avatars', 'public');
            $user->update(['image_url' => $imagePath]);
        }

        return back();
    }

}
