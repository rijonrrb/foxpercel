<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\UserSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{

    public function index()
    {
        $data['title']  = 'Settings';
        $settings = UserSetting::where('user_id', Auth::user()->id)->first();
        return view('user.settings', compact('data', 'settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|max:11',
            'seo_title' => 'nullable|max:70',
        ], [
            'site_name.max' => 'The SMS Sender Name must not exceed 11 characters.',
            'seo_title.max' => 'The Site Title must not exceed 70 characters.',
        ]);

        DB::beginTransaction();
        try {
            $setting = UserSetting::updateOrCreate(
                ['user_id' => Auth::user()->id],
                [
                    'site_name'            => $request->site_name,
                    'seo_title'            => $request->seo_title,
                    'seo_meta_description' => $request->seo_meta_desc,
                    'seo_keywords'         => $request->meta_keywords,
                    'main_motto'           => $request->main_motto,
                    'alarm_label'          => $request->alarm_label,
                    'table_heading_1'      => $request->table_heading_1,
                    'table_heading_2'      => $request->table_heading_2,
                    'table_heading_3'       => $request->table_heading_3,
                    'user_id'              => Auth::user()->id,
                ]
            );
            
            if ($request->favicon) {
                $favicon = $request->file('favicon');
                $base_name = preg_replace('/\..+$/', '', $favicon->getClientOriginalName());
                $base_name = Str::slug($base_name);
                $image_name = $base_name . "-" . uniqid() . "." . $favicon->getClientOriginalExtension();
                $file_path = '/assets/uploads/icon';
                $favicon->move(public_path($file_path), $image_name);
                $setting->update(['favicon' => $file_path . '/' . $image_name]);
            }
            
            if ($request->site_logo) {
                $site_logo = $request->file('site_logo');
                $base_name = preg_replace('/\..+$/', '', $site_logo->getClientOriginalName());
                $base_name = Str::slug($base_name);
                $image_name = $base_name . "-" . uniqid() . "." . $site_logo->getClientOriginalExtension();
                $file_path = '/assets/uploads/logo';
                $site_logo->move(public_path($file_path), $image_name);
                $setting->update(['site_logo' => $file_path . '/' . $image_name]);
            }
            
            if ($request->seo_image) {
                $seo_image = $request->file('seo_image');
                $base_name = preg_replace('/\..+$/', '', $seo_image->getClientOriginalName());
                $base_name = Str::slug($base_name);
                $image_name = $base_name . "-" . uniqid() . "." . $seo_image->getClientOriginalExtension();
                $file_path = '/assets/uploads/logo';
                $seo_image->move(public_path($file_path), $image_name);
                $setting->update(['seo_image' => $file_path . '/' . $image_name]);
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            Toastr::error(trans('Unable to update settings!'), 'Error', ["positionClass" => "toast-top-center"]);
            return redirect()->back();

        }

        DB::commit();
        Toastr::success(trans('Settings updated successfully!'), 'Success', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }

}
