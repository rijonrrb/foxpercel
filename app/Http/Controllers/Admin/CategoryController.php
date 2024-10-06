<?php


namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    // protected $category;
    // public $user;

    // public function __construct(Category $category)
    // {
    //     $this->category     = $category;
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
        // if (is_null($this->user) || !$this->user->can('admin.category.index')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $data['title'] = 'Item-Category';
        $data['rows'] = Category::orderBy('order_number', 'asc')->get();
        return view('admin.category.index', compact('data'));
    }


    public function store(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('admin.category.store')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $this->validate($request, [
            'name'          => 'required|max:100',
            'status'        => 'required'
        ]);

        DB::beginTransaction();
        try {

            $slug = Str::slug($request->name);
            $check_slug = Category::where('slug',$slug)->first();
            if($check_slug){
                $slug = $slug.'_'.uniqid();
            }

            $category = new Category();
            $category->name         = $request->name;
            $category->slug         = $slug;
            $category->order_number = Category::max('order_number') + 1;
            $category->status       = $request->status;
            $category->save();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error(trans('Failed to create the category. Please try again.'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.category.index');
        }
        DB::commit();
        Toastr::success(trans('Category created successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.category.index');
    }
    
    
    public function edit($id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.category.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $category = Category::find($id);
        $html = view('admin.category.edit', compact('category'))->render();
        return response()->json($html);
    }

    public function update(Request $request, $id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.category.update')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $this->validate($request, [
            'name'  => 'required|max:100',
            'status' => 'required'
        ]);
        
        DB::beginTransaction();
        try {

            $slug = Str::slug($request->name);
            $check_slug = Category::where('id','!=',$id)->where('slug',$slug)->first();

            if($check_slug){
                $slug = $slug.'_'.uniqid();
            }

            $category = Category::find($id);
            $category->name         = $request->name;
            $category->slug         = $slug;
            $category->status       = $request->status;
            $category->save();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error(trans('Unable to update the category. Please try again.'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.category.index');
        }
        DB::commit();
        Toastr::success(trans('Category updated successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.category.index');
    }



    public function delete($id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.category.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        try {
            $category = Category::findOrFail($id);
            $category->delete();
        } catch (\Exception $e) {
            Toastr::error(trans('Failed to delete the category. Please try again.'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->route('admin.category.index');
        }
        Toastr::success(trans('Category deleted successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.category.index');
    }


}
