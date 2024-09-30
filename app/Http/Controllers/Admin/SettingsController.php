<?php

namespace App\Http\Controllers\Admin;

use DateTimeZone;
use App\Mail\TestMail;
use App\Models\Setting;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Backup;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     protected $setting;
     public $user;
 
     public function __construct(Setting $setting)
     {
         $this->setting = $setting;
         $this->middleware(function ($request, $next) {
             $this->user = Auth::guard('admin')->user();
             return $next($request);
         });
     }


    // Setting
    public function general()
    {
        // if (is_null($this->user) || !$this->user->can('admin.settings.index')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }

        $data['title']  = 'Settings';
        $settings       = Setting::first();
        $config         = DB::table('config')->get();

        return view('admin.settings', compact('data', 'settings', 'config'));
    }

    // Update Setting
    public function generalStore(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $setting                    = Setting::find(1);
            $setting->site_name         = $request->site_name;
            $setting->site_title        = $request->site_title;
            // $setting->email             = $request->email;
            // $setting->support_email     = $request->support_email;
            $setting->phone_no          = $request->phone_no;
            $setting->seo_keywords      = $request->meta_keywords;
            $setting->authenticator     = $request->authenticator;
            $setting->status            = 1;


            if ($request->favicon) {
                $favicon = $request->file('favicon');
                $base_name = preg_replace('/\..+$/', '', $favicon->getClientOriginalName());
                $base_name = explode(' ', $base_name);
                $base_name = implode('-', $base_name);
                $base_name = Str::lower($base_name);
                $image_name = $base_name . "-" . uniqid() . "." . $favicon->getClientOriginalExtension();
                $file_path = '/assets/uploads/icon';
                $favicon->move(public_path($file_path), $image_name);
                $setting->favicon = $file_path . '/' . $image_name;
            }
            if ($request->site_logo) {
                $site_logo = $request->file('site_logo');
                $base_name = preg_replace('/\..+$/', '', $site_logo->getClientOriginalName());
                $base_name = explode(' ', $base_name);
                $base_name = implode('-', $base_name);
                $base_name = Str::lower($base_name);
                $image_name = $base_name . "-" . uniqid() . "." . $site_logo->getClientOriginalExtension();
                $file_path = '/assets/uploads/logo';
                $site_logo->move(public_path($file_path), $image_name);
                $setting->site_logo = $file_path . '/' . $image_name; $site_logo;
            }
            if ($request->seo_image) {
                $seo_image = $request->file('seo_image');
                $base_name = preg_replace('/\..+$/', '', $seo_image->getClientOriginalName());
                $base_name = explode(' ', $base_name);
                $base_name = implode('-', $base_name);
                $base_name = Str::lower($base_name);
                $image_name = $base_name . "-" . uniqid() . "." . $seo_image->getClientOriginalExtension();
                $file_path = '/assets/uploads/logo';
                $seo_image->move(public_path($file_path), $image_name);
                $setting->seo_image = $file_path . '/' . $image_name;
            }

            $setting->update();

            $double_site_name = str_replace('"', '', trim($request->site_name, '"'));
            $space_name = str_replace("'", '', trim($double_site_name, "'"));
            $site_name = str_replace(" ", '', trim($space_name, " "));

            DB::table('config')->where('config_key', 'site_name')->update([
                'config_value' => $site_name
            ]);


        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return redirect()->back()->with('error', 'Settings not Updated');
        }

        DB::commit();
        Toastr::success(trans('Settings Updated Successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }





    public function taxSetting()
    {
        $config = DB::table('config')->get();
        $settings = Setting::first();

        return view('admin.tax.index', compact('config', 'settings'));
    }

    public function updateTaxSetting(Request $request)
    {

        DB::table('config')->where('config_key', 'invoice_prefix')->update([
            'config_value' => $request->invoice_prefix,
        ]);

        DB::table('config')->where('config_key', 'invoice_name')->update([
            'config_value' => $request->invoice_name,
        ]);

        DB::table('config')->where('config_key', 'invoice_email')->update([
            'config_value' => $request->invoice_email,
        ]);

        DB::table('config')->where('config_key', 'invoice_phone')->update([
            'config_value' => $request->invoice_phone,
        ]);

        DB::table('config')->where('config_key', 'invoice_address')->update([
            'config_value' => $request->invoice_address,
        ]);

        DB::table('config')->where('config_key', 'invoice_city')->update([
            'config_value' => $request->invoice_city,
        ]);

        DB::table('config')->where('config_key', 'invoice_state')->update([
            'config_value' => $request->invoice_state,
        ]);

        DB::table('config')->where('config_key', 'invoice_zipcode')->update([
            'config_value' => $request->invoice_zipcode,
        ]);

        DB::table('config')->where('config_key', 'invoice_country')->update([
            'config_value' => $request->invoice_country,
        ]);

        DB::table('config')->where('config_key', 'tax_name')->update([
            'config_value' => $request->tax_name,
        ]);

        DB::table('config')->where('config_key', 'tax_number')->update([
            'config_value' => $request->tax_number,
        ]);

        DB::table('config')->where('config_key', 'tax_value')->update([
            'config_value' => $request->tax_value,
        ]);

        DB::table('config')->where('config_key', 'invoice_footer')->update([
            'config_value' => $request->invoice_footer,
        ]);


        Toastr::success(trans('Invoice Setting Updated Successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.tax.setting');
    }

    public function updateEmailSetting(Request $request)
    {

        DB::table('config')->where('config_key', 'email_heading')->update([
            'config_value' => $request->email_heading,
        ]);

        DB::table('config')->where('config_key', 'email_footer')->update([
            'config_value' => $request->email_footer,
        ]);


        Toastr::success(trans('Email Setting Updated Successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->route('admin.tax.setting');
    }

    public function pages()
    {
        $pages = DB::table('pages')->get()->groupBy('page_name');
        $settings = Setting::first();
        $config = DB::table('config')->get();
        $allPages = array_keys($pages->toArray());
        return view('admin.pages.index', compact('allPages', 'settings', 'config'));
    }

    public function editHomePage(Request $request, $id)
    {
        $sections = DB::table('pages')->where('page_name', $id)->get();
        $settings = Setting::first();
        $config = DB::table('config')->get();

        $section_name = DB::table('pages')->where('page_name', $id)->groupBy('section_name')->orderBy('order_id', 'asc')->get();


        return view('admin.pages.edit-page', compact('sections', 'settings', 'config', 'id', 'section_name'));
    }

    public function updateHomePage(Request $request, $id)
    {
        $_path = 'assets/uploads/banner';
        if (!File::exists($_path)) {
            File::makeDirectory($_path);
        }
        if ($request->banner_title) {
            $banner_title = $request->banner_title;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'banner_title')->update(['section_content' => $banner_title]);
        }

        if ($request->banner_description) {
            $banner_description = $request->banner_description;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'banner_description')->update(['section_content' => $banner_description]);
        }

        if ($request->banner_button) {
            $banner_button = $request->banner_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'banner_button')->update(['section_content' => $banner_button]);
        }



        if ($request->hasFile('banner_photo')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'banner_photo')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $banner_photo = $request->file('banner_photo');
            $name  = time() . '.' . $banner_photo->getClientOriginalExtension();
            Image::make($banner_photo)->save('assets/uploads/banner/' . $name);
            $banner_photo_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'banner_photo')->update(['section_content' => $banner_photo_path]);
        }

        if ($request->hasFile('banner_video')) {
            $rules = [
                'banner_video'          => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040|required'
            ];
            $validator = Validator($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $old_file = DB::table('pages')->where('page_name', $id)->where('section_title', 'banner_video')->first();
            if (!empty($old_file)) {
                if (File::exists(public_path($old_file->section_content))) {
                    File::delete(public_path($old_file->section_content));
                }
            }
            $banner_video = $request->file('banner_video');
            $base_name = preg_replace('/\..+$/', '', $banner_video->getClientOriginalName());
            $video_name = $base_name . "-" . uniqid() . "." . $banner_video->getClientOriginalExtension();
            $file_path = 'assets/uploads/videos';
            if (!File::exists($file_path)) {
                File::makeDirectory($file_path);
            }
            $banner_video->move($file_path, $video_name);
            $video_file = '/' . $file_path . '/' . $video_name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'banner_video')->update(['section_content' => $video_file]);
        }



        if ($request->hasFile('what_photo')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'what_photo')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $what_photo = $request->file('what_photo');
            $name  = time() . '.' . $what_photo->getClientOriginalExtension();
            Image::make($what_photo)->save('assets/uploads/banner/' . $name);

            $what_photo_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_photo')->update(['section_content' => $what_photo_path]);
        }


        if ($request->hasFile('feature_card_icon_1')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_1')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card_icon_1 = $request->file('feature_card_icon_1');
            $name  = time() . '.' . $feature_card_icon_1->getClientOriginalExtension();
            Image::make($feature_card_icon_1)->save('assets/uploads/banner/' . $name);

            $feature_card_icon_1_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_1')->update(['section_content' => $feature_card_icon_1_path]);
        }

        if ($request->hasFile('feature_card_icon_2')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_2')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card_icon_2 = $request->file('feature_card_icon_2');
            $name  = time() . '.' . $feature_card_icon_2->getClientOriginalExtension();
            Image::make($feature_card_icon_2)->save('assets/uploads/banner/' . $name);

            $feature_card_icon_2_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_2')->update(['section_content' => $feature_card_icon_2_path]);
        }
        if ($request->hasFile('feature_card_icon_3')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_3')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card_icon_3 = $request->file('feature_card_icon_3');
            $name  = time() . '.' . $feature_card_icon_3->getClientOriginalExtension();
            Image::make($feature_card_icon_3)->save('assets/uploads/banner/' . $name);

            $feature_card_icon_3_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_3')->update(['section_content' => $feature_card_icon_3_path]);
        }

        if ($request->hasFile('feature_card_icon_4')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_4')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card_icon_4 = $request->file('feature_card_icon_4');
            $name  = time() . '.' . $feature_card_icon_4->getClientOriginalExtension();
            Image::make($feature_card_icon_4)->save('assets/uploads/banner/' . $name);

            $feature_card_icon_4_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_4')->update(['section_content' => $feature_card_icon_4_path]);
        }
        if ($request->hasFile('feature_card_icon_5')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_5')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card_icon_5 = $request->file('feature_card_icon_5');
            $name  = time() . '.' . $feature_card_icon_5->getClientOriginalExtension();
            Image::make($feature_card_icon_5)->save('assets/uploads/banner/' . $name);

            $feature_card_icon_5_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_5')->update(['section_content' => $feature_card_icon_5_path]);
        }
        if ($request->hasFile('feature_card_icon_6')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_6')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card_icon_6 = $request->file('feature_card_icon_6');
            $name  = time() . '.' . $feature_card_icon_6->getClientOriginalExtension();
            Image::make($feature_card_icon_6)->save('assets/uploads/banner/' . $name);

            $feature_card_icon_6_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_6')->update(['section_content' => $feature_card_icon_6_path]);
        }
        if ($request->hasFile('feature_card_icon_7')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_7')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card_icon_7 = $request->file('feature_card_icon_7');
            $name  = time() . '.' . $feature_card_icon_7->getClientOriginalExtension();
            Image::make($feature_card_icon_7)->save('assets/uploads/banner/' . $name);

            $feature_card_icon_7_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_7')->update(['section_content' => $feature_card_icon_7_path]);
        }

        if ($request->what_mini_title) {
            $what_mini_title = $request->what_mini_title;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_mini_title')->update(['section_content' => $what_mini_title]);
        }

        if ($request->hasFile('feature_card_icon_8')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_8')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card_icon_8 = $request->file('feature_card_icon_8');
            $name  = time() . '.' . $feature_card_icon_8->getClientOriginalExtension();
            Image::make($feature_card_icon_8)->save('assets/uploads/banner/' . $name);

            $feature_card_icon_8_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_icon_8')->update(['section_content' => $feature_card_icon_8_path]);
        }
        if ($request->hasFile('feature_card9_photo')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card9_photo')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card9_photo = $request->file('feature_card9_photo');
            $name  = time() . '.' . $feature_card9_photo->getClientOriginalExtension();
            Image::make($feature_card9_photo)->save('assets/uploads/banner/' . $name);

            $feature_card9_photo_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card9_photo')->update(['section_content' => $feature_card9_photo_path]);
        }

        if ($request->hasFile('feature_card10_photo')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card10_photo')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card10_photo = $request->file('feature_card10_photo');
            $name  = time() . '.' . $feature_card10_photo->getClientOriginalExtension();
            Image::make($feature_card10_photo)->save('assets/uploads/banner/' . $name);

            $feature_card10_photo_path = 'assets/uploads/img/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card10_photo')->update(['section_content' => $feature_card10_photo_path]);
        }
        if ($request->hasFile('feature_card11_photo')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card11_photo')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card11_photo = $request->file('feature_card11_photo');
            $name  = time() . '.' . $feature_card11_photo->getClientOriginalExtension();
            Image::make($feature_card11_photo)->save('assets/uploads/banner/' . $name);

            $feature_card11_photo_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card11_photo')->update(['section_content' => $feature_card11_photo_path]);
        }

        if ($request->hasFile('feature_card12_photo')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card12_photo')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // __add new image
            $feature_card12_photo = $request->file('feature_card12_photo');
            $name  = time() . '.' . $feature_card12_photo->getClientOriginalExtension();
            Image::make($feature_card12_photo)->save('assets/uploads/banner/' . $name);

            $feature_card12_photo_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card12_photo')->update(['section_content' => $feature_card12_photo_path]);
        }

        if ($request->what_mini_title) {
            $what_mini_title = $request->what_mini_title;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_mini_title')->update(['section_content' => $what_mini_title]);
        }
        if ($request->hasFile('feature_card13_photo')) {
            // __delete old image
            $old_data = DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card13_photo')->first();
            if ($old_data) {
                $imagePath = public_path($old_data->section_content);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            // __add new image
            $feature_card13_photo = $request->file('feature_card13_photo');
            $name  = time() . '.' . $feature_card13_photo->getClientOriginalExtension();
            Image::make($feature_card13_photo)->save('assets/uploads/banner/' . $name);

            $feature_card13_photo_path = 'assets/uploads/banner/' . $name;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card13_photo')->update(['section_content' => $feature_card13_photo_path]);
        }

        if ($request->what_mini_title) {
            $what_mini_title = $request->what_mini_title;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_mini_title')->update(['section_content' => $what_mini_title]);
        }

        if ($request->what_title) {
            $what_title = $request->what_title;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_title')->update(['section_content' => $what_title]);
        }

        if ($request->what_description) {
            $what_description = $request->what_description;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_description')->update(['section_content' => $what_description]);
        }

        if ($request->what_li_title_1) {
            $what_li_title_1 = $request->what_li_title_1;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_li_title_1')->update(['section_content' => $what_li_title_1]);
        }

        if ($request->what_li_title_2) {
            $what_li_title_2 = $request->what_li_title_2;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_li_title_2')->update(['section_content' => $what_li_title_2]);
        }

        if ($request->what_li_title_3) {
            $what_li_title_3 = $request->what_li_title_3;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_li_title_3')->update(['section_content' => $what_li_title_3]);
        }

        if ($request->what_card_title_1) {
            $what_card_title_1 = $request->what_card_title_1;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_card_title_1')->update(['section_content' => $what_card_title_1]);
        }
        if ($request->what_card_description_1) {
            $what_card_description_1 = $request->what_card_description_1;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_card_description_1')->update(['section_content' => $what_card_description_1]);
        }
        if ($request->what_card_title_2) {
            $what_card_title_2 = $request->what_card_title_2;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_card_title_2')->update(['section_content' => $what_card_title_2]);
        }

        if ($request->what_card_description_2) {
            $what_card_description_2 = $request->what_card_description_2;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_card_description_2')->update(['section_content' => $what_card_description_2]);
        }

        if ($request->what_card_title_3) {
            $what_card_title_3 = $request->what_card_title_3;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_card_title_3')->update(['section_content' => $what_card_title_3]);
        }

        if ($request->what_card_description_3) {
            $what_card_description_3 = $request->what_card_description_3;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_card_description_3')->update(['section_content' => $what_card_description_3]);
        }

        if ($request->what_card_title_4) {
            $what_card_title_4 = $request->what_card_title_4;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_card_title_4')->update(['section_content' => $what_card_title_4]);
        }
        if ($request->what_card_description_4) {
            $what_card_description_4 = $request->what_card_description_4;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'what_card_description_4')->update(['section_content' => $what_card_description_4]);
        }

        if ($request->feature_card_title_1) {
            $feature_card_title_1 = $request->feature_card_title_1;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_1')->update(['section_content' => $feature_card_title_1]);
        }
        if ($request->feature_card_description_1) {
            $feature_card_description_1 = $request->feature_card_description_1;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_1')->update(['section_content' => $feature_card_description_1]);
        }
        if ($request->feature_card1_button) {
            $feature_card1_button = $request->feature_card1_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card1_button')->update(['section_content' => $feature_card1_button]);
        }


        if ($request->feature_card_title_2) {
            $feature_card_title_2 = $request->feature_card_title_2;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_2')->update(['section_content' => $feature_card_title_2]);
        }

        if ($request->feature_card_description_2) {
            $feature_card_description_2 = $request->feature_card_description_2;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_2')->update(['section_content' => $feature_card_description_2]);
        }
        if ($request->feature_card2_button) {
            $feature_card2_button = $request->feature_card2_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card2_button')->update(['section_content' => $feature_card2_button]);
        }

        if ($request->feature_card_title_3) {
            $feature_card_title_3 = $request->feature_card_title_3;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_3')->update(['section_content' => $feature_card_title_3]);
        }

        if ($request->feature_card_description_3) {
            $feature_card_description_3 = $request->feature_card_description_3;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_3')->update(['section_content' => $feature_card_description_3]);
        }
        if ($request->feature_card3_button) {
            $feature_card3_button = $request->feature_card3_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card3_button')->update(['section_content' => $feature_card3_button]);
        }
        if ($request->feature_card_title_4) {
            $feature_card_title_4 = $request->feature_card_title_4;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_4')->update(['section_content' => $feature_card_title_4]);
        }

        if ($request->feature_card_description_4) {
            $feature_card_description_4 = $request->feature_card_description_4;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_4')->update(['section_content' => $feature_card_description_4]);
        }
        if ($request->feature_card4_button) {
            $feature_card4_button = $request->feature_card4_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card4_button')->update(['section_content' => $feature_card4_button]);
        }

        if ($request->feature_card_title_5) {
            $feature_card_title_5 = $request->feature_card_title_5;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_5')->update(['section_content' => $feature_card_title_5]);
        }

        if ($request->feature_card_description_5) {
            $feature_card_description_5 = $request->feature_card_description_5;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_5')->update(['section_content' => $feature_card_description_5]);
        }
        if ($request->feature_card5_button) {
            $feature_card5_button = $request->feature_card5_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card5_button')->update(['section_content' => $feature_card5_button]);
        }

        if ($request->feature_card_title_6) {
            $feature_card_title_6 = $request->feature_card_title_6;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_6')->update(['section_content' => $feature_card_title_6]);
        }

        if ($request->feature_card_description_6) {
            $feature_card_description_6 = $request->feature_card_description_6;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_6')->update(['section_content' => $feature_card_description_6]);
        }
        if ($request->feature_card6_button) {
            $feature_card6_button = $request->feature_card6_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card6_button')->update(['section_content' => $feature_card6_button]);
        }
        if ($request->feature_card_title_7) {
            $feature_card_title_7 = $request->feature_card_title_7;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_7')->update(['section_content' => $feature_card_title_7]);
        }

        if ($request->feature_card_description_7) {
            $feature_card_description_7 = $request->feature_card_description_7;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_7')->update(['section_content' => $feature_card_description_7]);
        }
        if ($request->feature_card7_button) {
            $feature_card7_button = $request->feature_card7_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card7_button')->update(['section_content' => $feature_card7_button]);
        }
        if ($request->feature_card_title_8) {
            $feature_card_title_8 = $request->feature_card_title_8;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_8')->update(['section_content' => $feature_card_title_8]);
        }

        if ($request->feature_card_description_8) {
            $feature_card_description_8 = $request->feature_card_description_8;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_8')->update(['section_content' => $feature_card_description_8]);
        }
        if ($request->feature_card8_button) {
            $feature_card8_button = $request->feature_card8_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card8_button')->update(['section_content' => $feature_card8_button]);
        }
        if ($request->feature_card_title_9) {
            $feature_card_title_9 = $request->feature_card_title_9;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_9')->update(['section_content' => $feature_card_title_9]);
        }

        if ($request->feature_card_description_9) {
            $feature_card_description_9 = $request->feature_card_description_9;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_9')->update(['section_content' => $feature_card_description_9]);
        }
        if ($request->feature_card9_button) {
            $feature_card9_button = $request->feature_card9_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card9_button')->update(['section_content' => $feature_card9_button]);
        }

        if ($request->feature_card_title_10) {
            $feature_card_title_10 = $request->feature_card_title_10;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_10')->update(['section_content' => $feature_card_title_10]);
        }

        if ($request->feature_card_description_10) {
            $feature_card_description_10 = $request->feature_card_description_10;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_10')->update(['section_content' => $feature_card_description_10]);
        }
        if ($request->feature_card10_button) {
            $feature_card10_button = $request->feature_card10_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card10_button')->update(['section_content' => $feature_card10_button]);
        }
        if ($request->feature_card_title_11) {
            $feature_card_title_11 = $request->feature_card_title_11;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_11')->update(['section_content' => $feature_card_title_11]);
        }

        if ($request->feature_card_description_11) {
            $feature_card_description_11 = $request->feature_card_description_11;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_11')->update(['section_content' => $feature_card_description_11]);
        }
        if ($request->feature_card11_button) {
            $feature_card11_button = $request->feature_card11_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card11_button')->update(['section_content' => $feature_card11_button]);
        }
        if ($request->feature_card_title_12) {
            $feature_card_title_12 = $request->feature_card_title_12;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_title_12')->update(['section_content' => $feature_card_title_12]);
        }

        if ($request->feature_card_description_12) {
            $feature_card_description_12 = $request->feature_card_description_12;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card_description_12')->update(['section_content' => $feature_card_description_12]);
        }
        if ($request->feature_card12_button) {
            $feature_card12_button = $request->feature_card12_button;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'feature_card12_button')->update(['section_content' => $feature_card12_button]);
        }


        if ($request->video_section_title) {
            $video_section_title = $request->video_section_title;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'video_section_title')->update(['section_content' => $video_section_title]);
        }

        if ($request->video_section_content) {
            $video_section_content = $request->video_section_content;
            DB::table('pages')->where('page_name', $id)->where('section_title', 'video_section_content')->update(['section_content' => $video_section_content]);
        }


        // for ($i = 0; $i < count($sections); $i++) {
        //     $safe_section_content = $request->input('section' . $i);
        //     DB::table('pages')->where('page_name', $id)->where('id', $sections[$i]->id)->update(['section_content' => $safe_section_content]);
        // }
        Toastr::success(trans('Website Content Updated Successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }

    public function clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        Toastr::success(trans('Website Cache Cleared Successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }

    public function testEmail()
    {
        $message = [
            'msg' => 'Test mail'
        ];
        $mail = false;
        try {
            Mail::to(ENV('MAIL_FROM_ADDRESS'))->send(new \App\Mail\TestMail($message));
            $mail = true;
        } catch (\Exception $e) {

            Toastr::success(trans('Email configuration wrong.'), 'Success', ["positionClass" => "toast-top-center"]);
            return redirect()->back();
        }
        if ($mail == true) {

            Toastr::success(trans('Test mail send successfully.'), 'Success', ["positionClass" => "toast-top-center"]);
            return redirect()->back();
        }
    }

    protected function changeEnv($data = array())
    {
        if (count($data) > 0) {

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);

            // Loop through given data
            foreach ((array) $data as $key => $value) {

                // Loop through .env-data
                foreach ($env as $env_key => $env_value) {

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }


    public function backup()
    {
        // if (is_null($this->user) || !$this->user->can('admin.backup-file.index')) {
        //     abort(403, 'Sorry !! You are Unauthorized.');
        // }
        $settings = getSetting();
        $data['rows'] = Backup::paginate(10);
        return view('admin.settings.backup', compact('data', 'settings'));
    }

    public function backupDB()
    {
        $filename = "database-backup-" . Carbon::now()->format('Y-m-d-His') . ".sql";
        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w+');
            fwrite($handle, "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n");
            fwrite($handle, "SET time_zone = \"+00:00\";\n");
            fwrite($handle, "START TRANSACTION;\n");
            $tables = DB::select('SHOW TABLES');

            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{'Create Table'};
                fwrite($handle, "$createTable;\n\n");
                $rows = DB::select("SELECT * FROM `$tableName`");
                foreach ($rows as $row) {
                    $columns = array_keys((array)$row);
                    $values = array_map(function ($column) use ($row) {
                        return is_null($row->$column) ? 'NULL' : '"' . addslashes($row->$column) . '"';
                    }, $columns);
                    fwrite($handle, "INSERT INTO `$tableName` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n");
                }

                fwrite($handle, "\n");
            }

            fwrite($handle, "COMMIT;\n");

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/sql');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
    public function scheduleBackupDB()
    {
        $filename = "database-backup-" . Carbon::now()->format('Y-m-d-His') . ".sql";
        $filePath = public_path('uploads/backup/' . $filename);
    
        if (!file_exists(public_path('uploads/backup'))) {
            mkdir(public_path('uploads/backup'), 0777, true);
        }
    
        $handle = fopen($filePath, 'w+');
        
        fwrite($handle, "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n");
        fwrite($handle, "SET time_zone = \"+00:00\";\n");
        fwrite($handle, "START TRANSACTION;\n");
    
        $tables = DB::select('SHOW TABLES');
    
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{'Create Table'};
            fwrite($handle, "$createTable;\n\n");
    
            $rows = DB::select("SELECT * FROM `$tableName`");
            foreach ($rows as $row) {
                $columns = array_keys((array)$row);
                $values = array_map(function ($column) use ($row) {
                    return is_null($row->$column) ? 'NULL' : '"' . addslashes($row->$column) . '"';
                }, $columns);
                fwrite($handle, "INSERT INTO `$tableName` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n");
            }
    
            fwrite($handle, "\n");
        }
    
        fwrite($handle, "COMMIT;\n");
        fclose($handle);

        Log::info('Database backup saved successfully at: ' . $filePath);
    }
    
    public function backupProject()
    {
        $zip = new ZipArchive;
        $filename = "project-backup-" . Carbon::now()->format('Y-m-d-His') . ".zip";
        $zipFilePath = storage_path($filename);

        if (File::exists($zipFilePath)) {
            File::delete($zipFilePath);
        }

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $this->addFilesToZip($zip, base_path());
            // $this->addFilesToZip($zip, resource_path('views'));
            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function addFilesToZip($zip, $folder, $parentFolder = '')
    {
        $files = File::allFiles($folder);
        $folders = File::directories($folder);

        foreach ($files as $file) {
            $relativePath = $parentFolder . '/' . $file->getRelativePathname();
            $zip->addFile($file->getRealPath(), $relativePath);
        }

        foreach ($folders as $folder) {
            $this->addFilesToZip($zip, $folder, $parentFolder . '/' . basename($folder));
        }
    }

    public function scheduleBackupProject()
    {
        $filename = "project-backup-" . Carbon::now()->format('Y-m-d-His') . ".zip";
        $zipFilePath = public_path('uploads/backup/' . $filename);

        if (!file_exists(public_path('uploads/backup'))) {
            mkdir(public_path('uploads/backup'), 0777, true);
        }

        if (File::exists($zipFilePath)) {
            File::delete($zipFilePath);
        }

        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $this->addFilesToZip($zip, base_path());
            $zip->close();
        }

        Log::info('Project backup saved successfully at: ' . $zipFilePath);
    }

    public function scheduleBackupStore(Request $request) 
    {
        $request->validate([
            'backup_datetime' => 'required',
            'backup_item' => 'required',
        ]);
        
        DB::beginTransaction();
        try {
            $backup  = new Backup();
            $backup->item       = $request->backup_item;
            $backup->date       = $request->backup_datetime;
            $backup->status     = 0;

            $backup->save();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to schedule the backup. Please try again.', 'Backup Error', ["positionClass" => "toast-top-center"]);
            return back();
        }
        DB::commit();
        Toastr::success('The backup has been scheduled successfully!', 'Backup Success', ["positionClass" => "toast-top-center"]);
        return back();
    }
}


