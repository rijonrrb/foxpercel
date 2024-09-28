<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    

    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->status == 0) {
            // Toastr::error('Your account is inactive and cannot login.');
            return false;
        }
        // $user->generateGoogle2FASecret();

        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }
    protected function sendFailedLoginResponse(Request $request)
    {

        if (User::where('email', $request->input('email'))->where('status', 0)->exists()) {
            throw ValidationException::withMessages([
                'email' => ['Your account is inactive and cannot login'],
            ]);
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }
    public function showLoginForm(Request $request)
    {
        // $ipAddress = $request->ip();
        // $valid_user = User::whereJsonContains('ip_address', $ipAddress)->first();
 
        // if (!$valid_user) {
        //     return view('errors.ip_error');
        // }
        return view('auth.login');
    }

    // protected $redirectTo;

    // protected function redirectTo() {

    //     if(auth()->user()->role_id == 1 ) {

    //         return route('user.dashboard');

    //     }elseif(auth()->user()->role_id == 2 ) {

    //         return route('staff.dashboard');

    //     }else {
    //         $this->redirectTo = route('login');
    //     }

    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }


    public function logout(Request $request)
    {

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }


}

