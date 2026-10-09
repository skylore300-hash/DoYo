<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSellerPasswordRequest;
use App\Http\Requests\UpdateSellerProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SellerSettingsController extends Controller
{
    public function edit(Request $request): View
    {
        abort_unless($request->user()?->isSeller(), 403);

        return view('seller.settings');
    }

    public function updateProfile(UpdateSellerProfileRequest $request): RedirectResponse
    {
        $seller = $request->user();
        $oldAvatarPath = $seller->getRawOriginal('avatar_path');
        $seller->update($request->safe()->only(['name', 'city', 'email']));

        if ($request->hasFile('avatar')) {
            $newAvatarPath = $request->file('avatar')->store('avatars', 'public');

            if (is_string($oldAvatarPath) && $oldAvatarPath !== '') {
                Storage::disk('public')->delete($oldAvatarPath);
            }

            $seller->update(['avatar_path' => $newAvatarPath]);
        }

        return back()->with('status', 'Votre profil vendeur a été mis à jour.');
    }

    public function updatePassword(UpdateSellerPasswordRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return back()->with('password_status', 'Votre mot de passe a été modifié.');
    }
}
