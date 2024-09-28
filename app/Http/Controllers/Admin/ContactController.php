<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class ContactController extends Controller
 {
    public $user;
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact     = $contact;
       $this->middleware(function ($request, $next) {
             $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }



    public function index()
    {
       if (is_null($this->user) || !$this->user->can('admin.contact.index')) {
            abort(403, 'Sorry !! You are Unauthorized.');
       }

        $data['title']  = 'Contact';
        $data['rows']   =  Contact::orderBy('id', 'desc')->get();
        return view('admin.contact.index',compact('data'));
   }

   public function view($id)
   {

       if (is_null($this->user) || !$this->user->can('admin.contact.view')) {
           abort(403, 'Sorry !! You are Unauthorized.');
       }

       $data['row']= Contact::find($id);
       $html = view('admin.contact.view', compact('data'))->render();
       return response()->json($html);
   }


   public function delete($id)
   {
       if (is_null($this->user) || !$this->user->can('admin.contact.delete')) {
           abort(403, 'Sorry !! You are Unauthorized.');
       }

       DB::beginTransaction();
       try {
           $category = Contact::find($id);
           $category->delete();
       } catch (\Exception $e) {
           DB::rollback();
           Toastr::error(trans('Contact not Deleted !'), 'Error', ["positionClass" => "toast-top-center"]);
           return redirect()->route('admin.contact.index');
       }
       DB::commit();
       Toastr::success(trans('Contact Deleted Successfully !'), 'Success', ["positionClass" => "toast-top-center"]);
       return redirect()->route('admin.contact.index');
   }



}
