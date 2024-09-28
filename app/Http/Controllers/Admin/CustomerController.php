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

        $data['title'] = 'Customers';
        $data['rows'] = User::where('role_id', 1)->latest()->paginate(20);
        return view('admin.customer.index', compact('data'));
    }

    public function create(){
        // if (is_null($this->user) || !$this->user->can('admin.customer.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        $data['title'] = 'Customer Create';
        $data['roles'] = Role::orderBy('name', 'asc')->get();
        return view('admin.customer.create', compact('data'));
    }

    public function store(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('admin.customer.create')) {
            // abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $this->validate($request, [
            'name'           => 'required|max:100',
            'email'          => 'required|unique:users,email',
            'password'       => 'required|min:6|max:11',
            'phone'          => 'required',
            'address'        => 'nullable',
            'image'          => 'nullable',
            'status'         => 'required',
            'ip_address'     => 'required',
            'authenticator'  => 'required',
        ]);

        $imagePath = null;
        DB::beginTransaction();
        try {
            // if ($request->hasFile('image')) {
            //     $image = Image::make($request->file('image'));

            //     $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            //     $destinationPath = public_path('assets/images/customer/');
            //     $image->save($destinationPath . $imageName);
            //     $imagePath = 'assets/images/customer/' . $imageName;
            // }

            $customer = new User();
            $customer->role_id          = 1;
            $customer->parent_user      = 0;
            $customer->user_id          = uniqid();
            $customer->name             = $request->name;
            $customer->email            = $request->email;
            $customer->password         = bcrypt($request->password);
            $customer->phone            = $request->phone;
            $customer->image            = $imagePath;
            $customer->address          = $request->address;
            // $customer->ip_address    = $request->ip_address;
            $customer->ip_address       = json_encode($request->ip_address);
            $customer->status           = $request->status;
            $customer->authenticator    = $request->authenticator;
            $customer->save();

            $customerSettings = new UserSetting();
            $customerSettings->user_id = $customer->id;
            $customerSettings->save();
            
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            Toastr::error(trans('Customer not Created !'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.customer.index');
        }
        DB::commit();
        Toastr::success(trans('Customer Created Successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.customer.index');
    }

    public function edit($id)
    {

        // if (is_null($this->user) || !$this->user->can('admin.customer.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        $data['title'] = 'Edit Customer';
        $data['user'] = User::findOrFail($id);
        $data['role'] = Role::orderBy('name', 'asc')->get();
        return view('admin.customer.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.customer.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        $customer = User::find($id);
        $this->validate($request, [
            'name'           => 'required|max:100',
            'email'          => 'required|unique:users,email,'. $customer->id,
            'phone'          => 'required',
            'address'        => 'nullable',
            'ip_address'     => 'required',
            'image'          => 'nullable',
            'status'         => 'required',
            'authenticator'  => 'required',

        ]);

        DB::beginTransaction();
        try {
            $customer->name             = $request->name;
            $customer->email            = $request->email;
            $customer->phone            = $request->phone;
            $customer->address          = $request->address;
            $customer->authenticator    = $request->authenticator;

            if ($request->has('ip_address')) {
                $customer->ip_address    = json_encode($request->ip_address);
                User::where('parent_user', $customer->id)
                    ->update(['ip_address' => json_encode($request->ip_address)]);
            }

            if ($request->has('status')) {
                $customer->status = $request->status;
            
                User::where('parent_user', $customer->id)
                ->update(['status' => $request->status]);
                
                // if ($request->status == 0) {
                //     User::where('parent_user', $customer->id)
                //         ->update(['status' => $request->status]);
                // }
            }
            
            if(isset($request->password) && !empty($request->password)) 
            {
                $customer->password      = bcrypt($request->password);
            }


            // if ($request->hasFile('image')) {
            //     $image = Image::make($request->file('image'));
            //     $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            //     $destinationPath = public_path('assets/images/customer/');
            //     $image->save($destinationPath . $imageName);
            //     $customer->image = 'assets/images/customer/' . $imageName;

            // }
            User::where('parent_user', $customer->id)->update(['ip_address' => json_encode($request->ip_address)]);
            
            $customer->save();

        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            Toastr::error(trans('Customer not Updated !'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.customer.index');
        }
        DB::commit();
        Toastr::success(trans('Customer Updated Successfully !'), 'Success', ["positionClass" => "toast-top-center"]);
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
            $staffs = User::where('parent_user', $id)->get();

            foreach ($staffs as $staff) {
                $imagePath = asset($staff->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $staff->delete();
            }

            Alarm::where('user_id', $id)->delete();
            NotificationTemplate::where('user_id', $id)->delete();
            DefconLevel::where('user_id', $id)->delete();
            UserSetting::where('user_id', $id)->delete();

            $customerImagePath = asset($customer->image);
            if (File::exists($customerImagePath)) {
                File::delete($customerImagePath);
            }

            $customer->delete();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error(trans('Customer not Deleted !'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.customer.index');
        }
        DB::commit();
        Toastr::success(trans('Customer Deleted Successfully !'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.customer.index');
    }

    public function view($id){
        if (is_null($this->user) ||!$this->user->can('admin.customer.index')) {
            abort(403, 'Sorry!! You are Unauthorized.');
        }
        $data['title'] = 'Customer View';
        $data['user'] = User::find($id);
        return view('admin.customer.view', compact('data'));
    }

    
    public function staff($id)
    {
        // if (is_null($this->user) ||!$this->user->can('admin.staff.index')) {
        //     abort(403, 'Sorry!! You are Unauthorized.');
        // }
        $data['title'] = 'Customer User';
        return view('admin.customer.staff', compact('data'));
    }

    public function authAs(Request $request, $id)
    {
        $user_details = User::where('id', $id)->where('status', 1)->first();
        if (isset($user_details)) {
            Auth::guard('user')->loginUsingId($user_details->id);
            return redirect()->route('user.dashboard');
        } else {
            return redirect()->route('admin.customer.index')->with('info', 'Customer account not found!');
        }
    }
}
