<?php


namespace App\Http\Controllers\User;

use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
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

    public function create()
    {
        $data['title'] = 'Order Create';
        // $data['rows'] = Percel::orderBy('id', 'desc')->get();
        return view('user.order.create', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'item_category_id' => 'required|exists:categories,id',
            'item_name' => 'required|string|max:255',
            'item_price' => 'required|numeric',
            'currency' => 'required|string',
            'item_weight' => 'required|numeric',
            'item_color' => 'nullable|string|max:100',
            'item_size' => 'nullable|string|max:50',
            'item_quantity' => 'required|integer',
            'item_model' => 'nullable|string|max:100',
            'note' => 'nullable|string',
            'prescription' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        DB::beginTransaction();
        try {
            $item = new Item();
            $item->item_category_id = $request->item_category_id;
            $item->item_name = $request->item_name;
            $item->item_price = $request->item_price;
            $item->currency = $request->currency;
            $item->item_weight = $request->item_weight;
            $item->item_color = $request->item_color;
            $item->item_size = $request->item_size;
            $item->item_quantity = $request->item_quantity;
            $item->item_model = $request->item_model;
            $item->note = $request->note;

            // If prescription is uploaded
            if ($request->hasFile('prescription')) {
                $prescription = $request->file('prescription');
                $base_name  = preg_replace('/\..+$/', '', $prescription->getClientOriginalName());
                $base_name  = explode(' ', $base_name);
                $base_name  = implode('-', $base_name);
                $base_name  = Str::lower($base_name);
                $prescription_name = $base_name . "-" . uniqid() . "." . $prescription->getClientOriginalExtension();
                $file_path  = 'uploads/prescriptions';
                $prescription->move(public_path($file_path), $prescription_name);
                $item->prescription = $file_path . '/' . $prescription_name;
            }
            
            $item->save();

            // Create a new Order
            // $order = new Order();
            // $order->item_id = $item->id;
            // $order->shopping_from_country = $request->shopping_from_country;
            // $order->delivery_country = $request->delivery_country;
            // $order->total_gross_weight = $request->total_gross_weight;
            // $order->total_dimension_weight = $request->total_dimension_weight;
            // $order->step = 1;
            // $order->status = 0;
            // $order->save();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to create the item and order. Please try again!', 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.order.index');
        }

        DB::commit();
        Toastr::success('Item successfully added for this order!', 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.order.index');
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
            'name'   => 'max:100|unique:countries,name,'.$id,
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
