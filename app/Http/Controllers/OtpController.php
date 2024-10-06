<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationMail;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function otpForm(){
        $settings = getSetting();
        $data['settings'] = $settings;
        return view('auth.otp_form', $data);
    }

    public function otpsend(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    
        $user = auth()->user();
        $settings = getSetting();
    
        $otp = rand(100000, 999999);
        while (OtpVerification::where('otp', $otp)->exists()) {
            $otp = rand(100000, 999999);
        }
    
        $otpVerification = OtpVerification::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today());
    
        $otp_count = $otpVerification->exists() 
            ? $otpVerification->latest('created_at')->first()->otp_count + 1 
            : 1;
    
        if ($otp_count <= $settings->daily_otp_sms_limit) {
            try {
                $result = OtpVerification::create([
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'otp_date' => now(),
                    'expire_time' => now()->addMinutes(5),
                    'otp' => $otp,
                    'otp_count' => $otp_count,
                ]);
    
                if ($result) {
                    $msg = [
                        'subject' => 'Your One-Time Password (OTP) for Secure Access',
                        'greeting' => 'Hello ' . $user->name,
                        'body' => '<p>Your OTP code is <strong>' . $otp . '</strong>.</p><p>This code will expire in 5 minutes.</p>',
                        'thanks' => 'Thank you for using ' . ($settings->site_name ?? config('app.name')),
                        'site_url' => route('home'),
                        'site_name' => ($settings->site_name ?? config('app.name')),
                        'copyright' => '© ' . Carbon::now()->format('Y') . ' ' . ($settings->site_name ?? config('app.name')) . ' All rights reserved.',
                    ];
    
                    Mail::to($user->email)->send(new ConfirmationMail($msg));
    
                    Toastr::success('OTP sent successfully!', 'Success', ["positionClass" => "toast-top-right"]);
                    return redirect()->route('user.otp.form');
                } else {
                    throw new \Exception('Unable to send OTP. Please try again.');
                }
            } catch (\Exception $e) {
                Toastr::error('Error: ' . $e->getMessage(), 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
        } else {
            Toastr::warning('You have exceeded the resend limit!', 'Warning', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }
    

    public function otpVerification(Request $request)
    {
        try {
            $authUser = auth()->user();
            $otpValue = $request->digit1 . $request->digit2 . $request->digit3 . $request->digit4 . $request->digit5 . $request->digit6;
    
            $otpVerification = OtpVerification::where('user_id', $authUser->id)
                ->where('otp', $otpValue)
                ->where('expire_time', '>', now())
                ->first();
    
            if ($otpVerification) {
                $user = User::find($authUser->id);
                $user->otp_verified_at = now();
                $user->save();
                
                $otpVerification->status = 1;
                $otpVerification->save;
                // Toastr::success(trans('Your account has been successfully verified!'), 'Success', ["positionClass" => "toast-top-right"]);
                return redirect()->route('user.dashboard');
            } else {
                Toastr::error(trans('Incorrect OTP or OTP expired. Please try again.'), 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            dd($e);
            Toastr::error('An error occurred: ' . $e->getMessage(), 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }
    
}
