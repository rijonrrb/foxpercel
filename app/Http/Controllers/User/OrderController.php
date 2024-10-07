<?php


namespace App\Http\Controllers\User;

use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{


    public function index()
    {
        $data['title'] = 'Order List';
        // $data['rows'] = Percel::orderBy('id', 'desc')->get();
        return view('user.order.index', compact('data'));
    }

    public function create(Request $request)
    {
        $data['title'] = 'Order Create';
        $data['categories'] = Category::where('status', 1)->orderBy('order_number', 'asc')->get();
        if ($request->has('order')) {
            $data['order'] = Order::findOrFail($request->order);
        }
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
            // Create a new Order
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->total_item = 0;
            $order->total_gross_weight = 0;
            $order->total_dimension_weight = 0;
            $order->total_amount = 0;
            $order->shipping_amount = 0;
            $order->apply_coupon = 0;
            $order->step = 1;
            $order->status = 0;
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
            }
    
            $order->total_item = count($request->item_name);
            $order->total_gross_weight = array_sum($request->item_weight);
            $order->total_amount = array_sum($request->item_price);
            $order->step = 2;
            $order->save();
    
    
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
        DB::commit();
        Toastr::success('Item information successfully submitted! Proceed to next step.');
        return redirect()->route('user.order.create', ['order' => $order->id]);
    }

    public function edit($id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.country.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        // $country = Country::find($id);
        // $html = view('admin.country.edit', compact('country'))->render();
        // return response()->json($html);
    }

    public function update(Request $request, $id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.country.update')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        $this->validate($request, [
            'name'   => 'max:100|unique:countries,name,' . $id,
            'code'   => 'required|max:10',
        ]);

        // DB::beginTransaction();
        // try {

        //     $country = Country::find($id);
        //     $country->name         = $request->name;
        //     $country->code         = $request->code;
        //     $country->save();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Toastr::error(trans('Failed to update the country. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
        //     return redirect()->route('admin.country.index');
        // }
        // DB::commit();
        // Toastr::success(trans('Country updated successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        // return redirect()->route('admin.country.index');
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
}
