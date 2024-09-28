<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RandomException
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            // dd($user);

            // Find the user in the database by their email
            $existingUser = User::where('email', $user->email)->first();
            if ($existingUser) {
                if($existingUser->role_id == 1){
                    Auth::login($existingUser);
                    return redirect()->route('user.dashboard');
                }else{
                    Auth::login($existingUser);
                    return redirect()->route('staff.dashboard');
                }
            } else {
                // If user is not found, show an error message and redirect back
                Toastr::error('No account found with this Email.', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->route('login');
            }

        } catch (\Exception $e) {
            // dd($e);
            // Handle any other errors
            Toastr::error('Something went wrong, please try again.', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->route('login');
        }
    }
}
