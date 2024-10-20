<?php


namespace App\Http\Controllers\Admin;


use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alarm;
use App\Models\DefconLevel;
use App\Models\NotificationTemplate;
use App\Models\UserSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{

    protected $customer;
    public $user;

    public function __construct(User $customer)
    {
        $this->customer     = $customer;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the categories.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (is_null($this->user) || !$this->user->can('admin.customer.index')) {
            // abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $data['title'] = 'User-List';
        $data['rows'] = User::orderBy('name', 'asc')->get();
        return view('admin.customer.index', compact('data'));
    }

    public function create(){
        // if (is_null($this->user) || !$this->user->can('admin.customer.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        $data['title'] = 'User-Create';
        return view('admin.customer.create', compact('data'));
    }

    public function store(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('admin.customer.create')) {
            // abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $this->validate($request, [
            'name'           => 'required|string|max:80',
            'email'          => 'required|string|email|max:128|unique:users,email',
            'password'       => 'required|min:6',
            'phone'          => 'required|max:20|unique:users,phone',
            'address'        => 'nullable|max:255',
            'image'          => 'nullable',
            'status'         => 'required',
        ]);

        DB::beginTransaction();
        try {

            $customer = new User();
            $customer->name             = $request->name;
            $customer->email            = $request->email;
            $customer->password         = bcrypt($request->password);
            $customer->phone            = $request->phone;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $base_name  = preg_replace('/\..+$/', '', $image->getClientOriginalName());
                $base_name  = explode(' ', $base_name);
                $base_name  = implode('-', $base_name);
                $base_name  = Str::lower($base_name);
                $image_name = $base_name . "-" . uniqid() . "." . $image->getClientOriginalExtension();
                $file_path  = 'uploads/user';
                $image->move(public_path($file_path), $image_name);
                $customer->image  = $file_path . '/' . $image_name;
            }

            $customer->address          = $request->address;
            $customer->status           = $request->status;
            $customer->email_verified_at    = now();
            $customer->save();
            
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            Toastr::error(trans('Failed to create the user. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.customer.index');
        }
        DB::commit();
        Toastr::success(trans('User created successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.customer.index');
    }

    public function edit($id)
    {

        // if (is_null($this->user) || !$this->user->can('admin.customer.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        $data['title'] = 'User-Edit';
        $data['user'] = User::findOrFail($id);
        return view('admin.customer.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.customer.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        $customer = User::find($id);

        $this->validate($request, [
            'name'           => 'required|string|max:80',
            'email'          => 'required|string|email|max:128|unique:users,email,'. $customer->id,
            'phone'          => 'required|max:20|unique:users,phone,'. $customer->id,
            'address'        => 'nullable|max:255',
            'image'          => 'nullable',
            'status'         => 'required',
        ]);


        DB::beginTransaction();
        try {
            $customer->name             = $request->name;
            $customer->email            = $request->email;
            $customer->phone            = $request->phone;
            $customer->address          = $request->address;
            $customer->status           = $request->status;

            if ($request->hasFile('image')) {

                if (File::exists($customer->image)) {
                    File::delete($customer->image);
                }
                $image = $request->file('image');
                $base_name  = preg_replace('/\..+$/', '', $image->getClientOriginalName());
                $base_name  = explode(' ', $base_name);
                $base_name  = implode('-', $base_name);
                $base_name  = Str::lower($base_name);
                $image_name = $base_name . "-" . uniqid() . "." . $image->getClientOriginalExtension();
                $file_path  = 'uploads/user';
                $image->move(public_path($file_path), $image_name);
                $customer->image  = $file_path . '/' . $image_name;
            }
            
            $customer->save();

        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            Toastr::error(trans('Failed to update the user. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.customer.index');
        }
        DB::commit();
        Toastr::success(trans('User updated successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.customer.index');
    }



    public function delete($id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.customer.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        DB::beginTransaction();
        try {
            $customer = User::findOrFail($id);
            if (File::exists($customer->image)) {
                File::delete($customer->image);
            }
            $customer->delete();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error(trans('Failed to delete the user. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.customer.index');
        }
        DB::commit();
        Toastr::success(trans('User deleted successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.customer.index');
    }

    public function view($id){
        // if (is_null($this->user) ||!$this->user->can('admin.customer.index')) {
        //     abort(403, 'Sorry!! You are Unauthorized.');
        // }
        $data['title'] = 'User-details';
        $data['user'] = User::find($id);
        return view('admin.customer.view', compact('data'));
    }

    public function passwordUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'password'          => 'required|min:6',
        ]);

        try {
            $user  = User::find($id);
            $user->password = bcrypt($request->password);
            $user->update();

        } catch (\Exception $e) {
            Toastr::error(trans('An unexpected error occured while updating password'), trans('Error'), ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
        Toastr::success(trans('Password updated successfully'), trans('Success'), ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }

    // public function authAs(Request $request, $id)
    // {
    //     $user_details = User::where('id', $id)->where('status', 1)->first();
    //     if (isset($user_details)) {
    //         Auth::guard('user')->loginUsingId($user_details->id);
    //         return redirect()->route('user.dashboard');
    //     } else {
    //         return redirect()->route('admin.customer.index')->with('info', 'Customer account not found!');
    //     }
    // }
}
