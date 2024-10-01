<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Admin;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\BusinessCard;
use Illuminate\Http\Request;
use App\Models\BusinessField;
use App\Mail\SendEmailInvoice;
use App\Actions\User\UpdateUser;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $admin;
    public $user;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // All Users
    public function index(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('admin.user.index')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $users = Admin::latest()->get();
        return view('admin.users.index', compact('users'));
    }


    public function create(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('admin.user.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $users = Admin::where('user_type', '2')->orderBy('created_at', 'desc')->where('status','!=',2);
        if($request->date){
            $users->whereDate('created_at','=',date('Y-m-d', strtotime($request->date)));
        }
        $users = $users->orderBy('users.name','ASC')->get();
        $settings = Setting::where('status', 1)->first();
        $config = DB::table('config')->get();

        return view('admin.users.create', compact('users', 'settings', 'config'));
    }


    public function store(Admin $user, StoreUserRequest $request)
    {
        // if (is_null($this->user) || !$this->user->can('admin.user.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }


        $user->create(array_merge($request->validated(), [
            'password' => 'test',
            'user_type' => '2'
        ]));

        return redirect()->route('admin.user.index')->withSuccess(__('User created successfully.'));
    }

    public function edit($id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.user.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $user = Admin::find($id);

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::latest()->get()
        ]);
    }


    public function update($id, UpdateUserRequest $request)
    {
        // if (is_null($this->user) || !$this->user->can('admin.user.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        DB::beginTransaction();
        try {
            $user = Admin::find($id);
            UpdateUser::update($request, $user);

        } catch (\Throwable $th) {

            // dd($th);
            DB::rollBack();
            return back();
        }

        DB::commit();
        return redirect()->route('admin.user.index') ->withSuccess(__('User updated successfully.'));
    }

    // Login As User
    public function authAs(Request $request, $id)
    {
        $user_details = Admin::where('id', $id)->where('status', 1)->first();
        if (isset($user_details)) {
            Auth::loginUsingId($user_details->id);
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('admin.users')->with('info', 'User account was not found!');
        }
    }


    public function destroy($id){
        // if (is_null($this->user) || !$this->user->can('admin.user.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        Admin::find($id)->delete();
        Toastr::success(trans('User Deleted Successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }





}
