<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use App\Models\Backup;
use App\Models\Faq;
use App\Models\User;
use App\Models\Franchise;
use App\Models\CustomPage;
use App\Models\DefconLevel;
use App\Models\Setting;
use App\Models\UserSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{


    public function landingPage(){
        $settings = getSetting();
        $data['settings'] = $settings;
        return view('frontend.home', $data);
    }

    public function index(Request $request)
    {
        $settings = getSetting();
        $data['settings'] = $settings;
        $selectedDefconLevel = $request->defcon_level;

        if ($selectedDefconLevel) {
            $defcon =  DefconLevel::where('id', $selectedDefconLevel)->first();
            $data['selectedDefconLevel'] = $selectedDefconLevel;
            $data['level_title'] = $defcon->defcon_level;
            $data['level_color'] = $defcon->color;

        } else {
            $defcon = DefconLevel::where('user_id', 0)->where('is_default', 1)->first();
            $data['selectedDefconLevel'] = $defcon->id;
            $data['level_title'] = $defcon->defcon_level;
            $data['level_color'] = $defcon->color;
        }
        $data['rows'] = Alarm::where('user_id', 0)->latest()->get();

        $data['defcon_levels'] = DefconLevel::where('user_id', 0)->get();
        return view('frontend.index', $data);
    }
    
    public function privacyPolicy()
    {
        $data['title'] = 'Privacy Policy';
        $data['og_title'] = '';
        $data['og_description'] = '';
        $data['og_image'] = '';
        $data['row'] = CustomPage::where('url_slug', 'privacy-policy')->first();
        return view('frontend.custom_page', $data);
    }

    public function termsCondition()
    {
        $data['title'] = 'Terms Condition';
        $data['og_title'] = '';
        $data['og_description'] = '';
        $data['og_image'] = '';
        $data['row'] = CustomPage::where('url_slug', 'terms-and-conditions')->first();
        return view('frontend.custom_page', $data);
    }

    public function faq()
    {
        $data['title'] = 'FAQ';
        $data['og_title'] = '';
        $data['og_description'] = '';
        $data['og_image'] = '';
        $data['faqs'] = Faq::get();

        return view('frontend.faq', $data);
    }

    public function about()
    {
        $data['title'] = 'About';
        $data['og_title'] = '';
        $data['og_description'] = '';
        $data['og_image'] = '';
        $data['aboput'] = '';
        return view('frontend.about', $data);
    }

    public function contact()
    {
        $data['title'] = 'Contact';
        $data['og_title'] = '';
        $data['og_description'] = '';
        $data['og_image'] = '';
        $data['contact'] = '';
        return view('frontend.contact', $data);
    }

    public function disclaimer()
    {
        $data['title'] = 'disclaimer';
        $data['og_title'] = '';
        $data['og_description'] = '';
        $data['og_image'] = '';
        $data['disclaimer'] = '';
        return view('frontend.disclaimer', $data);
    }

    public function blogs()
    {
        $data['title'] = 'Blogs';
        $data['og_title'] = '';
        $data['og_description'] = '';
        $data['og_image'] = '';
        $data['blogs'] = '';
        return view('frontend.blogs.index', $data);
    }

    public function blogsDetails($slug)
    {
        $data['title'] = 'Blog Details';
        $data['og_title'] = '';
        $data['og_description'] = '';
        $data['og_image'] = '';
        $data['bolg'] = '';
        return view('frontend.blogs.details', $data);
    }

    
    public function cc(){
        // Toastr::success(trans('Cache clear successfully !'), 'Success', ["positionClass" => "toast-top-right"]);

        // \Artisan::call('php artisan cache:forget spatie.permission.cache');
        Artisan::call('route:clear');
        Artisan::call('optimize');
        Artisan::call('optimize:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('storage:link');
        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('config:cache');

        echo 'Done';
        die();
        // return redirect()->back();
    }

    // public function alarm(Request $request, $slug)
    // {
    //     $user = User::where('user_id', $slug)->where('status', 1)->firstOrFail();


    //     if (!Auth::guard('admin')->check()) 
    //     {
    //         // $response = Http::get('https://api.ipify.org?format=json');
    //         // $ipAddress = $response->json('ip');
    //         // $ipAddress = getUserIpAddr();
    //         $ipAddress = $request->ip();
    //         $valid_user = User::whereJsonContains('ip_address', $ipAddress)->first();

    //         // dd($slug, $ipAddress, $valid_user);
            
    //         if(!$valid_user) {
    //             // abort(403);
    //             return view('errors.ip_error');
    //             // echo "<p style='text-align: center;font-size: 25px;color: #e11919;text-transform: uppercase;padding: 20px 0px; '> Access Denied <br><br> Your IP address is not authorized to access this site. If you believe this is an error or require assistance, please contact us for further guidance. </p>"; die();
    //         }
    //     }
        
    //     $settings = UserSetting::where('user_id', $user->id)->first();
    //     $user_id = $settings->user_id;
    //     $data['settings'] = $settings;

    //     $data['rows'] = Alarm::where('user_id', $settings->user_id)->orderBy('order_number', 'ASC')->get();
    //     if($data['rows']->count() < 1) {
    //         return view('errors.alarm_error', $data);
    //         // echo "<p style='text-align: center; font-size: 25px; color: #e11919; text-transform: uppercase; padding: 20px 0px;'> Alarm is not available! </p>";
    //         // die();
    //     } 

    //     $selectedDefconLevel = $request->defcon_level;
        
    //     if ($selectedDefconLevel) {
    //         $defcon =  DefconLevel::where('id', $selectedDefconLevel)->first();
    //         $data['selectedDefconLevel'] = $selectedDefconLevel;
    //         $data['level_title'] = $defcon->defcon_level;
    //         $data['level_color'] = $defcon->color;

    //     } else {
    //         $defcon = DefconLevel::where('user_id', $user_id)->where('is_default', 1)->first();
    //         $data['selectedDefconLevel'] = $defcon ? $defcon->id : '';
    //         $data['level_title'] = $defcon ? $defcon->defcon_level : '';
    //         $data['level_color'] = $defcon ? $defcon->color : '';
    //     }

    //     $data['defcon_levels'] = DefconLevel::where('user_id', $settings->user_id)->get();
    //     $data['slug'] = $slug;
    //     return view('frontend.public_page', $data);

    // }

    public function alarm(Request $request, $slug)
    {
        $user = User::where('user_id', $slug)->where('status', 1)->firstOrFail();
    
        if (!Auth::guard('admin')->check()) {
            $ipAddress = $request->ip();
            $valid_user = User::whereJsonContains('ip_address', $ipAddress)->first();
    
            if (!$valid_user) {
                return view('errors.ip_error');
            }
        }
    
        $settings = UserSetting::where('user_id', $user->id)->first();
        $user_id = $settings->user_id;
        $data['settings'] = $settings;
        $data['slug'] = $slug;
        $data['rows'] = Alarm::where('user_id', $settings->user_id)->orderBy('order_number', 'ASC')->get();
        if ($data['rows']->count() < 1) {
            return view('errors.alarm_error', $data);
        }
    
        $selectedDefconLevel = $request->defcon_level;
    
        if ($selectedDefconLevel) {
            $defcon = DefconLevel::where('id', $selectedDefconLevel)->first();
            $data['selectedDefconLevel'] = $selectedDefconLevel;
            $data['level_title'] = $defcon->defcon_level;
            $data['level_color'] = $defcon->color;
        } else {
            $defcon = DefconLevel::where('user_id', $user_id)->where('is_default', 1)->first();
            $data['selectedDefconLevel'] = $defcon ? $defcon->id : '';
            $data['level_title'] = $defcon ? $defcon->defcon_level : '';
            $data['level_color'] = $defcon ? $defcon->color : '';
        }
    
        if ($request->ajax()) {
            return response()->json([
                'table' => view('frontend.partials.alarm_table', ['rows' => $data['rows']])->render(),
                'level_title' => $data['level_title'],
                'level_color' => $data['level_color'],
                'alarm_label' => $settings->alarm_label ?? 'Current DEFCON Level'
            ]);
        }
    
        $data['defcon_levels'] = DefconLevel::where('user_id', $settings->user_id)->get();
        return view('frontend.public_page', $data);
    }
    

    public function scheduleBackup() 
    {
        $backups = Backup::where('status', 0)->get();
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
    
        $setting = Setting::first();
    
        if ($backups->count() > 0) {  
    
            foreach ($backups as $backup) {
                $backupDate = Carbon::parse($backup->date)->format('Y-m-d H:i:s');
                if ($currentDate >= $backupDate) {
                    $controller = new SettingsController($setting); 
                    
                    if ($backup->item == 'db') {
                        $controller->scheduleBackupDB();
                        $backup->update(['status' => 1]);
                    } elseif ($backup->item == 'project') {
                        $controller->scheduleBackupProject();
                        $backup->update(['status' => 1]);
                    }
                } 
            }
        } else {
            return 0;
        }
    
        return 1;
    }
    

}
