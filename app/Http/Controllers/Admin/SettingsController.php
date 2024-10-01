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


