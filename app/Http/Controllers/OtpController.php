<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
class OtpController extends Controller
{


    public function otpForm(){
        $settings = getSetting();
        $data['settings'] = $settings;
        return view('auth.otp_form', $data);
    }

    public function index(Request $request)
    {
        $settings = getSetting();
        $data['settings'] = $settings;
        $selectedDefconLevel = $request->defcon_level;

        if ($selectedDefconLevel) {
            $defcon =  DefconLevel::where('id', $selectedDefconLevel)->first();
            $data['selectedDefconLevel'] = $selectedDefconLevel;
            $data['level_title'] = $defcon->defcon_level;
            $data['level_color'] = $defcon->color;

        } else {
            $defcon = DefconLevel::where('user_id', 0)->where('is_default', 1)->first();
            $data['selectedDefconLevel'] = $defcon->id;
            $data['level_title'] = $defcon->defcon_level;
            $data['level_color'] = $defcon->color;
        }
        $data['rows'] = Alarm::where('user_id', 0)->latest()->get();

        $data['defcon_levels'] = DefconLevel::where('user_id', 0)->get();
        return view('frontend.index', $data);
    }

    function passwordResetOtpSend(Request $request)
    {
        $request->validate([
            'mobile' => "required",
        ]);
        return $this->otpsend($request);
    }

    function passwordResetOtpVerify(Request $request)
    {
        if ($request->isMethod('post')) {
            // $authUser = auth()->user();
            $digit1 = $request->digit1;
            $digit2 = $request->digit2;
            $digit3 = $request->digit3;
            $digit4 = $request->digit4;
            $digit5 = $request->digit5;
            $otpValue = $digit1 . $digit2 . $digit3 . $digit4 . $digit5;

            $result = OtpVerification::where('otp', $otpValue)
                ->where('expire_time', '>', now())
            ;
            if ($result->exists()) {

                auth()->loginUsingId($result->latest('created_at')->first()->user_id);

                Toastr::success(trans('Your OTP successfully verified!'), 'Success', ["positionClass" => "toast-top-right"]);
                return redirect()->route('user.profile.edit');
            } else {
                Toastr::error(trans('Incorrect OTP. Please try again.'), 'Error', ["positionClass" => "toast-top-right"]);
                return back();
            }
        } else {
            return view('otp.password-reset');
        }
    }

    public function otpsend(Request $request)
    {

        if(!auth()) {
            return redirect()->back();
        }

        $user = auth()->user();
    
        $otp = rand(10000, 99999);
        while (OtpVerification::where('otp', $otp)->exists()) {
            $otp = rand(10000, 99999);
        }
        $otpVerification = OtpVerification::where('user_id', $user->id)->whereDate('created_at', Carbon::today());

        $otp_count = $otpVerification->exists() ? $otpVerification->latest('created_at')->first()->otp_count + 1 : 1;

        if ($otp_count <= getSetting()->daily_otp_sms_limit) {
            $result = OtpVerification::create([
                'phone' => $user->phone,
                'email' => $user->email,
                'user_id' => $user->id,
                'otp_date' => now(),
                'otp' => $otp,
                'status' => '0',
                'created_at' => now(),
                'expire_time' => now()->addMinutes(5),
                'created_by' => $user->id,
                'otp_count' => $otp_count,
            ]);

            if ($result) {

                return redirect()->back();
            } else {
                Toastr::error(trans('Unable to send OTP. Please try again.'), 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
        } else {
            Toastr::warning(trans('You have exceeded the resend limit!'), 'Warning', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function otpVerification(Request $request)
    {

        $authUser = auth()->user();
        $digit1 = $request->digit1;
        $digit2 = $request->digit2;
        $digit3 = $request->digit3;
        $digit4 = $request->digit4;
        $digit5 = $request->digit5;
        $otpValue = $digit1 . $digit2 . $digit3 . $digit4 . $digit5;

        $result = OtpVerification::where('user_id', $authUser->id)
            ->where('otp', $otpValue)
            ->where('expire_time', '>', now())
            ->exists();
        if ($result) {
            $user = User::find($authUser->id);
            $user->phone_verified_at = now();
            $user->save();

            Toastr::success(trans('Your account has been successfully verified!'), 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->route('user.dashboard');
        } else {
            Toastr::error(trans('Incorrect OTP. Please try again.'), 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->route('user.dashboard');
        }
    }
}
