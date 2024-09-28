<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TwoFactorController extends Controller
{
    public function show2faForm()
    {
        $google2fa = new Google2FA();
        $user = User::where('id', Auth::id())->first();

        if (!$user->google2fa_secret) {
            $user->generateGoogle2FASecret();
        }

        $google2fa_url = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );
        $google2fa_secret = $user->google2fa_secret;
        return view('auth.2fa_enable', ['QR_Image' => $google2fa_url, 'secret' => $google2fa_secret]);
    }

    public function enable2fa(Request $request)
    {
        return view('auth.2fa');
    }


    public function verify2fa(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->input('otp'));

        if ($valid) {
            Session::put('2fa_verified', true);
            $user->update(['authentication_enable' =>  1]);
            return redirect()->intended();
        }

        return redirect()->back()->withErrors(['otp' => 'Invalid verification code']);
    }
}
