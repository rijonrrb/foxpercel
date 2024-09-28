<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alarm;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['title'] = 'Dashboard';
        return view('user.dashboard',compact('data'));
    }

    public function profile()
    {
        $data['title'] = 'Profile';
        $data['user'] = Auth::user();
         return view('user.profile',compact('data'));
    }
    public function profileUpdate(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $this->validate($request, [
            'name'  => 'required',
            'email'   => 'required|unique:users,email,' . $user->id . ',id',
            'phone'   => 'required',
            'address'  => 'required',
        ]);

        try {

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->ip_address = $request->ip_address;

            if ($request->hasFile('image')) {

                if (File::exists(public_path($user->image))) {
                    File::delete(public_path($user->image));
                }

                $image = $request->file('image');
                $base_name  = preg_replace('/\..+$/', '', $image->getClientOriginalName());
                $base_name  = explode(' ', $base_name);
                $base_name  = implode('-', $base_name);
                $base_name  = Str::lower($base_name);
                $image_name = $base_name . "-" . uniqid() . "." . $image->getClientOriginalExtension();
                $extension  = $image->getClientOriginalExtension();
                $file_path  = 'uploads/user';
                $image->move(public_path($file_path), $image_name);
                $user->image  = $file_path . '/' . $image_name;

            }

            $user->save();
        } catch (\Exception $e) {
            Toastr::error(trans('An unexpected error occured while updating profile information'), trans('Error'), ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        Toastr::success(trans('Profile information updated successfully'), trans('Success'), ["positionClass" => "toast-top-right"]);
        return redirect()->route('user.profile');
    }
    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'password'          => 'required|min:6',
            'confirm_password'  => 'required|same:password',
        ]);

        try {
            $user  = User::find(Auth::user()->id);
            $user->password = Hash::make($request->input('password'));
            $user->update();

        } catch (\Exception $e) {
            Toastr::error(trans('An unexpected error occured while updating password'), trans('Error'), ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
        Toastr::success(trans('Password updated successfully'), trans('Success'), ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }
}
