<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StaffController extends Controller
{

    public function index(Request $request)
    {
        $data['rows'] = User::where('role_id', 2)->where('parent_user', Auth::user()->id)->latest()->paginate(20);
        $data['title'] = 'User';
        return view('user.staff.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = 'User Create';
        $data['users'] = User::where('role_id', 1)->latest()->get();
        return view('user.staff.create', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|max:100',
            'email'             => 'required|unique:users,email,except,id',
            'phone'             => 'required',
            // 'ip_address'        => 'required',
            'image'             => 'nullable',
            'change_diffcon'    => 'required',
            'status'            => 'required',
            'password'          => 'required',
        ]);

        $imagePath = null;
        $user = Auth::user();
        DB::beginTransaction();
        try {
            // if ($request->hasFile('image')) {
            //     $image = Image::make($request->file('image'));

            //     $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            //     $destinationPath = public_path('assets/images/staff/');
            //     $image->save($destinationPath . $imageName);
            //     $imagePath = 'assets/images/staff/' . $imageName;
            // }

            $staff = new User();
            $staff->role_id         = 2;
            $staff->user_id         = uniqid();
            $staff->parent_user     = $user->id;
            $staff->name            = $request->name;
            $staff->email           = $request->email;
            $staff->phone           = $request->phone;
            $staff->password        = bcrypt($request->password);
            // $staff->ip_address      = $request->ip_address;
            // $staff->ip_address      = json_encode($request->ip_address);
            $staff->ip_address      = $user->ip_address;
            $staff->status          = $request->status;
            $staff->image           = $imagePath;
            $staff->change_diffcon  = $request->change_diffcon;

            $staff->save();
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            Toastr::error(trans('User not Created !'), 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->route('user.staff.index');
        }
        DB::commit();
        Toastr::success(trans('User Created Successfully!'), 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('user.staff.index');
    }

    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        $data['title'] = 'User Edit';
        $data['users'] = User::where('role_id', 1)->latest()->get();
        return view('user.staff.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::find($id);
        $this->validate($request, [
            'name'              => 'required|max:100',
            'email'             => 'required|unique:users,email,'. $staff->id,
            'phone'             => 'required',
            // 'ip_address'        => 'required',
            'image'             => 'nullable',
            'change_diffcon'    => 'required',
            'status'            => 'required',
        ]);


        DB::beginTransaction();
        try {
            $staff->name            = $request->name;
            $staff->email           = $request->email;
            $staff->phone           = $request->phone;
            // $staff->ip_address      = $request->ip_address;
            // $staff->ip_address      = json_encode($request->ip_address);
            $staff->status          = $request->status;

            if(isset($request->password) && !empty($request->password)) 
            {
                $staff->password   = bcrypt($request->password);
            }

            // if ($request->hasFile('image')) {
            //     $image = Image::make($request->file('image'));
            //     $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            //     $destinationPath = public_path('assets/images/staff/');
            //     $image->save($destinationPath . $imageName);
            //     $staff->image = 'assets/images/staff/' . $imageName;

            // }

            $staff->change_diffcon  = $request->change_diffcon;

            $staff->save();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            Toastr::error(trans('User not Updated !'), 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->route('user.staff.index');
        }
        DB::commit();
        Toastr::success(trans('User Updated Successfully!'), 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('user.staff.index');
    }
    public function view($id)
    {
        $data['user'] = User::findOrFail($id);
        $data['title'] = 'User View';
        return view('user.staff.view', compact('data'));
    }
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $staff = User::findOrFail($id);
            if (File::exists(asset($staff->image))) {
                File::delete(asset($staff->image));
            }
            $staff->delete();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error(trans('User not Deleted !'), 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->route('user.staff.index');
        }
        DB::commit();
        Toastr::success(trans('User Deleted Successfully !'), 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('user.staff.index');
    }

}
