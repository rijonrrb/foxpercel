<?php


namespace App\Http\Controllers\User;

use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Order;
use App\Models\UserCoupon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{


    public function index()
    {
        $data['title'] = 'Order List';
        // $data['rows'] = Percel::orderBy('id', 'desc')->get();
        $data['rows'] = Order::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
        return view('user.order.index', compact('data'));
    }

    public function create(Request $request)
    {
        $data['title'] = 'Order Details';
        $data['categories'] = Category::where('status', 1)->orderBy('order_number', 'asc')->get();
        $data['currencies'] = Currency::where('status', 1)->orderBy('name', 'asc')->get();
        return view('user.order.create', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'item_category_id.*' => 'required|exists:categories,id',
            'item_image.*' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'item_name.*' => 'required|string|max:255',
            'item_price.*' => 'required|numeric',
            'currency.*' => 'required|string',
            'item_weight.*' => 'required|numeric',
            'item_color.*' => 'nullable|string|max:100',
            'item_size.*' => 'nullable|string|max:50',
            'item_quantity.*' => 'required|integer',
            'item_model.*' => 'nullable|string|max:100',
            'item_link.*' => 'nullable|string',
            'note.*' => 'nullable|string',
            'prescription.*' => 'nullable|file|mimes:pdf,doc,docx',
        ]);
    
        DB::beginTransaction();
        try {
            $total_gross_weight = 0;
            $total_amount = 0;
            do {
                $uniqueId = 'ord_' . Str::random(16);
                $orderExists = Order::where('order_number', $uniqueId)->exists();
            } while ($orderExists); 

            // Create a new Order
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->order_number = $uniqueId;
            $order->total_item = 0;
            $order->total_gross_weight = 0;
            $order->total_dimension_weight = 0;
            $order->total_amount = 0;
            $order->shipping_amount = 0;
            $order->apply_coupon = 0;
            $order->step = 1;
            $order->status = 'incomplete';
            $order->payment_status = 'pending';
            $order->save();
    
            // Loop through each item and create them
            foreach ($request->item_name as $index => $itemName) {
                $item = new Item();
                $item->item_category_id = $request->item_category_id[$index];
                $item->item_name = $itemName;
                $item->item_price = $request->item_price[$index];
                $item->currency = $request->currency[$index];
                $item->item_link = $request->item_link[$index];
                $item->item_weight = $request->item_weight[$index];
                $item->item_color = $request->item_color[$index] ?? null;
                $item->item_size = $request->item_size[$index] ?? null;
                $item->item_quantity = $request->item_quantity[$index];
                $item->item_model = $request->item_model[$index] ?? null;
                $item->note = $request->note[$index] ?? null;
                $item->order_id = $order->id;
    
                if ($request->hasFile("item_image.$index")) {
                    $image = $request->file("item_image.$index");
                    $imageName = strtolower(str_replace(' ', '-', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)));
                    $fileName = $imageName . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $filePath = 'uploads/items';
                    $image->move(public_path($filePath), $fileName);
                    $item->image = $filePath . '/' . $fileName;
                }

                if ($request->hasFile("prescription.$index")) {
                    $prescription = $request->file("prescription.$index");
                    $prescriptionName = strtolower(str_replace(' ', '-', pathinfo($prescription->getClientOriginalName(), PATHINFO_FILENAME)));
                    $fileName = $prescriptionName . '-' . uniqid() . '.' . $prescription->getClientOriginalExtension();
                    $filePath = 'uploads/prescriptions';
                    $prescription->move(public_path($filePath), $fileName);
                    $item->prescription = $filePath . '/' . $fileName;
                }
    
                $item->save();
                $total_gross_weight = $total_gross_weight + ($request->item_quantity[$index] * $request->item_weight[$index]);
                $total_amount = $total_amount + ($request->item_quantity[$index] * $request->item_price[$index]);
            }
    
            $order->total_item = array_sum($request->item_quantity);
            $order->total_gross_weight = $total_gross_weight;
            $order->total_amount = $total_amount;
            $order->step = 2;
            $order->save();
    
    
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
        DB::commit();
        Toastr::success('Item information successfully submitted! Proceed to next step.');
        return redirect()->route('user.order.edit', $order->id);
    }

    public function edit($id)
    {
        $data['title'] = 'Order Details';
        $data['categories'] = Category::where('status', 1)->orderBy('order_number', 'asc')->get();
        $data['currencies'] = Currency::where('status', 1)->orderBy('name', 'asc')->get();
        $data['order'] = Order::findOrFail($id);
        $data['items'] = Item::where('order_id', $id)->get();
        $data['countries'] = Country::where('status', 1)->get();
        return view('user.order.edit', compact('data'));
    }

    public function update(Request $request, $orderId)
    {
        if ($request->step == 1) {
            $this->validate($request, [
                'item_category_id.*' => 'required|exists:categories,id',
                'item_image.*' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'item_name.*' => 'required|string|max:255',
                'item_price.*' => 'required|numeric',
                'currency.*' => 'required|string',
                'item_weight.*' => 'required|numeric',
                'item_color.*' => 'nullable|string|max:100',
                'item_size.*' => 'nullable|string|max:50',
                'item_quantity.*' => 'required|integer',
                'item_model.*' => 'nullable|string|max:100',
                'item_link.*' => 'nullable|string',
                'note.*' => 'nullable|string',
                'prescription.*' => 'nullable|file|mimes:pdf,doc,docx',
            ]);
        } elseif($request->step == 2) {
            $this->validate($request, [
                'shopping_country' => 'required|exists:countries,id',
                'delivery_country' => 'required|exists:countries,id',
                'total_gross_weight' => 'required|numeric',
                'total_dimension_weight' => 'required|numeric',
                'total_items' => 'required|numeric',
                'total_amount' => 'required|numeric',

            ]);
        }
    
        DB::beginTransaction();
        try {
            $total_gross_weight = 0;
            $total_amount = 0;

            $order = Order::findOrFail($orderId);
            if ($request->step == 1) {
                $items = Item::where('order_id', $orderId)->get();
                foreach($items as $data) {
                    if (!in_array($data->id, $request->item_id)) {
                        if (File::exists(public_path($data->image))) {
                            File::delete(public_path($data->image));
                        }
                
                        if (File::exists(public_path($data->prescription))) {
                            File::delete(public_path($data->prescription));
                        }
                    }
    
                    $data->delete();
                }
                foreach ($request->item_name as $index => $itemName) {
                    $item = new Item();
                    $item->item_category_id = $request->item_category_id[$index];
                    $item->item_name = $itemName;
                    $item->item_price = $request->item_price[$index];
                    $item->currency = $request->currency[$index];
                    $item->item_link = $request->item_link[$index];
                    $item->item_weight = $request->item_weight[$index];
                    $item->item_color = $request->item_color[$index] ?? null;
                    $item->item_size = $request->item_size[$index] ?? null;
                    $item->item_quantity = $request->item_quantity[$index];
                    $item->item_model = $request->item_model[$index] ?? null;
                    $item->note = $request->note[$index] ?? null;
                    $item->order_id = $order->id;
    
                    // Handle item image upload
                    if ($request->has('item_image_url') && !empty($request->item_image_url[$index])) {
                        $item->image = $request->item_image_url[$index];
                    }
                    if ($request->hasFile("item_image.$index")) {
                        $image = $request->file("item_image.$index");
                        $imageName = strtolower(str_replace(' ', '-', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)));
                        $fileName = $imageName . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $filePath = 'uploads/items';
                        $image->move(public_path($filePath), $fileName);
                        $item->image = $filePath . '/' . $fileName;
                    }
    
                    // Handle prescription file upload
                    if ($request->has('item_prescription_url') && !empty($request->item_prescription_url[$index])) {
                        $item->prescription = $request->item_prescription_url[$index];
                    }
                    if ($request->hasFile("prescription.$index")) {
                        $prescription = $request->file("prescription.$index");
                        $prescriptionName = strtolower(str_replace(' ', '-', pathinfo($prescription->getClientOriginalName(), PATHINFO_FILENAME)));
                        $fileName = $prescriptionName . '-' . uniqid() . '.' . $prescription->getClientOriginalExtension();
                        $filePath = 'uploads/prescriptions';
                        $prescription->move(public_path($filePath), $fileName);
                        $item->prescription = $filePath . '/' . $fileName;
                    }
    
                    $item->save();
                    
                    $total_gross_weight = $total_gross_weight + ($request->item_quantity[$index] * $request->item_weight[$index]);
                    $total_amount = $total_amount + ($request->item_quantity[$index] * $request->item_price[$index]);
                }
            }
            if ($request->step == 2) {
                $order->step = 3;
                $order->shopping_from_country_id = $request->shopping_country;
                $order->shopping_from_country = getCountry($request->shopping_country)->name;
                $order->delivery_country_id = $request->delivery_country;
                $order->delivery_country = getCountry($request->delivery_country)->name;
                $order->delivery_address = $request->delivery_address;
                $order->total_gross_weight = $request->total_gross_weight;
                $order->total_dimension_weight = $request->total_dimension_weight;
                $order->total_item = $request->total_items;
                $order->total_amount = $request->total_amount;
            } elseif($request->step == 1) {
                $order->total_item = array_sum($request->item_quantity);
                $order->total_gross_weight = $total_gross_weight;
                $order->total_amount = $total_amount;
            } elseif($request->step == 3) {
                $order->total_amount = $request->grand_total;
                $order->status = 'pending';
            }
            $order->save();

    
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
        DB::commit();
        Toastr::success('Item information successfully updated');

        if($request->step == 3) {
            return redirect()->route('user.order.index');
        }

        return redirect()->route('user.order.edit', $order->id);
    }



    public function delete($id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.country.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        // DB::beginTransaction();
        // try {
        //     $country = Country::find($id);
        //     $country->delete();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Toastr::error(trans('Failed to delete the country. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
        //     return redirect()->route('admin.country.index');
        // }
        // DB::commit();
        // Toastr::success(trans('Country deleted successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        // return redirect()->route('admin.country.index');
    }

    public function couponApply(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $orderNumber = $request->input('order_number');
        $amount = $request->input('total_amount');
        $loggedInUserId = Auth::id(); 
    
        if (empty($couponCode)) {
            return response()->json(['status' => false, 'error' => 'Please enter a coupon code to apply.']);
        }
    
        $coupon = Coupon::where('coupon_code', $couponCode)->where('status', 1)->first();
        if (!$coupon) {
            return response()->json(['status' => false, 'error' => 'Invalid coupon code.']);
        }
    
        $now = now();
        if ($now->lt($coupon->validity_from) || $now->gt($coupon->validity_to)) {
            return response()->json(['status' => false, 'error' => 'This coupon is not valid at this time.']);
        }

        /* 
        if ($amount < $coupon->order_min_value) {
            return response()->json(['status' => false, 'error' => 'The total amount is below the minimum value for this coupon.']);
        }
        */
    
        $couponApplyount = UserCoupon::where('user_id', $loggedInUserId)
            ->where('coupon_code', $couponCode)
            ->count();
    
        if ($couponApplyount >= $coupon->usability) {
            return response()->json(['status' => false, 'error' => 'You have already used this coupon.']);
        }
    
        $discount = ($coupon->coupon_type === 'percent') 
            ? ($coupon->amount / 100) * $amount 
            : $coupon->amount;
    
        $discountedAmount = max($amount - $discount, 0);
    
        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return response()->json(['status' => false, 'error' => 'Invalid order number.']);
        }

        // $order->total_amount = $discountedAmount;
        $order->apply_coupon = 1;
        $order->save();

        $user_coupon = new UserCoupon();
        $user_coupon->user_id = $loggedInUserId;
        $user_coupon->coupon_code = $couponCode;
        $user_coupon->save();

        return response()->json([
            'status' => true, 
            'discountedAmount' => $discountedAmount, 
            'discount' => $discount
        ]);
    }
    
}
