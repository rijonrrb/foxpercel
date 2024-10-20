<?php


namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{

    // protected $country;
    // public $user;

    // public function __construct(Country $country)
    // {
    //     $this->country     = $country;
    //     $this->middleware(function ($request, $next) {
    //         $this->user = Auth::guard('admin')->user();
    //         return $next($request);
    //     });
    // }
    /**
     * Display a listing of the categories.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (is_null($this->user) || !$this->user->can('admin.country.index')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $data['title'] = 'Currency';
        $data['rows'] = Currency::orderBy('name', 'asc')->get();
        return view('admin.currency.index', compact('data'));
    }


    public function store(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('admin.country.store')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $this->validate($request, [
            'name'      => 'required|unique:currencies,name|max:100',
            'code'      => 'required|max:10|unique:currencies,code',
            'symbol'    => 'required|max:3',
            'status'    => 'required',
        ]);

        DB::beginTransaction();
        try {

            $currency = new Currency();
            $currency->name         = $request->name;
            $currency->code         = $request->code;
            $currency->symbol       = $request->symbol;
            $currency->status       = $request->status;
            $currency->save();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error(trans('Failed to create the currency. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.currency.index');
        }
        DB::commit();
        Toastr::success(trans('Currency added successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.currency.index');
    }

    public function edit($id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.country.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $currency = Currency::find($id);
        $html = view('admin.currency.edit', compact('currency'))->render();
        return response()->json($html);
    }

    public function update(Request $request, $id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.country.update')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        $this->validate($request, [
            'name'      => 'max:100|unique:currencies,name,'.$id,
            'code'      => 'required|max:10|unique:currencies,code,'.$id,
            'symbol'    => 'required|max:3',
            'status'    => 'required',
        ]);

        DB::beginTransaction();
        try {

            $currency = Currency::find($id);
            $currency->name         = $request->name;
            $currency->code         = $request->code;
            $currency->symbol       = $request->symbol;
            $currency->status       = $request->status;
            $currency->save();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error(trans('Failed to update the currency. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.currency.index');
        }
        DB::commit();
        Toastr::success(trans('Currency updated successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.currency.index');
    }



    public function delete($id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.country.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        
        try {
            $currency = Currency::find($id);
            $currency->delete();
        } catch (\Exception $e) {
            Toastr::error(trans('Failed to delete the currency. Please try again!'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.currency.index');
        }
        Toastr::success(trans('Currency deleted successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.currency.index');
    }
}
