<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Alarm;
use App\Models\NotificationTemplate;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    //

    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        return view('admin.dashboard',compact('data'));
    }


    public function cacheClear(){
        Toastr::success(trans('Cache clear successfully !'), 'Success', ["positionClass" => "toast-top-right"]);

        // \Artisan::call('php artisan cache:forget spatie.permission.cache');
        Artisan::call('route:clear');
        Artisan::call('optimize');
        Artisan::call('optimize:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('storage:link');
        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('config:cache');

        // echo 'Done';
        // die();
        return redirect()->back();
    }

    public function adminProfile()
    {
        $data['title'] = 'Profile';
        $data['user'] = Auth::user();
         return view('admin.profile.index',compact('data'));
    }
    public function profileUpdate(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = Admin::where('id', $user_id)->first();
        $this->validate($request, [
            'name'  => 'required',
            'email'   => 'required|unique:admins,email,' . $user->id . ',id',
        ]);

        try {

            $user->name = $request->name;
            $user->email = $request->email;

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
                $file_path  = 'uploads/admin';
                $image->move(public_path($file_path), $image_name);
                $user->image  = $file_path . '/' . $image_name;

            }

            $user->save();
        } catch (\Exception $e) {
            Toastr::error(trans('An unexpected error occured while updating profile information'), trans('Error'), ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        Toastr::success(trans('Profile information updated successfully'), trans('Success'), ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.profile');
    }
    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'password'          => 'required|min:6',
            'confirm_password'  => 'required|same:password',
        ]);

        try {
            $user  = Admin::find(Auth::user()->id);
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
