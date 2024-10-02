<?php

namespace App\Http\Middleware;

use App\Models\OtpVerification;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOtpVerification
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $settings = getSetting();
    
        if ($settings->authenticator == 1 && is_null($user->otp_verified_at)) {
            $otpVerification = OtpVerification::where('user_id', $user->id)
                ->whereDate('otp_date', now()->toDateString())
                ->exists();
    
            if ($otpVerification) {
                return redirect()->route('user.otp.form');
            } else {
                return redirect()->route('user.otp.verification');
            }
        }
    
        return $next($request);
    }
}
