<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserCoupon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        $title = "Coupon";
        return view('admin.coupon.index', compact('coupons', 'title'));
        // return view('admin.index');
    }

    public function getCouponCodes(Request $request) {
        $selectedUserId = $request->input('user_id'); // Replace 'user_id' with your actual form input field name

        $user = User::find($selectedUserId);

        $couponCodes = $user->coupons->pluck('coupon_code');
        // dd($couponCodes);
        return $couponCodes;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'coupon_code' => 'required|string|max:255|unique:coupons',
            'validity_from' => 'required|date',
            'validity_to' => 'required|date',
            'coupon_type' => 'required',
            'amount' => 'required|numeric',
            // 'order_min_value' => 'required|numeric',
            'usability' => 'required|numeric',
            'status' => 'required|in:1,0',
        ]);

        try {
            DB::beginTransaction();

            $coupon = new Coupon;
            $coupon->name = $validatedData['name'];
            $coupon->coupon_code = $validatedData['coupon_code'];
            $coupon->validity_from = $validatedData['validity_from'];
            $coupon->validity_to = $validatedData['validity_to'];
            $coupon->amount = $validatedData['amount'];
            // $coupon->order_min_value = $validatedData['order_min_value'];
            $coupon->usability = $validatedData['usability'];
            $coupon->status = $validatedData['status'];
            $coupon->coupon_type = $validatedData['coupon_type'];
            $coupon->created_by = auth()->user()->id;
            $coupon->updated_by = auth()->user()->id;
            $coupon->save();

            DB::commit();
            Toastr::success(trans('Coupon added successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.coupon.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(trans('Failed to add the coupon. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.coupon.index');
        }

    }

    public function view($id)
    {
        $title = "Coupon View";
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.view', compact('coupon', 'title'));
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $title = "Coupon Edit";
        return view('admin.coupon.edit', compact('coupon', 'title'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'coupon_code' => 'required|string|max:255|unique:coupons,coupon_code,' . $id,
            'validity_from' => 'required|date',
            'validity_to' => 'required|date',
            'coupon_type' => 'required|in:percent,amount',
            'amount' => 'required|numeric',
            // 'order_min_value' => 'required|numeric',
            'usability' => 'required',
            'status' => 'required|in:1,0',
        ]);

        try {
            DB::beginTransaction();

            $coupon = Coupon::findOrFail($id);
            $coupon->name = $validatedData['name'];
            $coupon->coupon_code = $validatedData['coupon_code'];
            $coupon->validity_from = $validatedData['validity_from'];
            $coupon->validity_to = $validatedData['validity_to'];
            $coupon->amount = $validatedData['amount'];
            // $coupon->order_min_value = $validatedData['order_min_value'];
            $coupon->usability = $validatedData['usability'];
            $coupon->status = $validatedData['status'];
            $coupon->coupon_type = $validatedData['coupon_type'];

            $coupon->update();
            DB::commit();
            Toastr::success(trans('Coupon updated successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.coupon.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(trans('Failed to update the coupon. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.coupon.index');
        }
    }

    public function delete($id)
    {
        $coupon = Coupon::findOrFail($id);
        if ($coupon) {
            UserCoupon::where('coupon_id', $coupon->id)->delete();
        }
        $coupon->delete();
        Toastr::success(trans('Coupon deleted successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.coupon.index');
    }

}
