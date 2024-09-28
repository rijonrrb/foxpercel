<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TwoFactorController extends Controller
{
    protected $guard;

    public function __construct()
    {
        $this->guard = Auth::guard('admin');
    }

    public function show2faForm()
    {
        $google2fa = new Google2FA();
        $user = $this->guard->user();

        if (!$user->google2fa_secret) {
            $user->generateGoogle2FASecret();
        }

        $google2fa_url = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );
        $google2fa_secret = $user->google2fa_secret;
        return view('admin.auth.2fa_enable', ['QR_Image' => $google2fa_url, 'secret' => $google2fa_secret]);
    }

    public function enable2fa(Request $request)
    {
        return view('admin.auth.2fa');
    }


    public function verify2fa(Request $request)
    {
        $user = $this->guard->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->input('otp'));

        if ($valid) {
            Session::put('admin_2fa_verified', true);
            $user->update(['authentication_enable' =>  1]);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['otp' => 'Invalid verification code']);
    }
}
