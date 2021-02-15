<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Settings;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use  Carbon\Carbon, File;

class SettingsController extends Controller
{
    use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->data['setting'] = $this->getSetting('config');
         //dd($this->data['setting']);
        return view('settings::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('settings::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }
    public static function getSettings() {
        $setting_data = array();

        $query = Settings::all();
        foreach ($query as $result) {
            if (!$result->serialized) {
                $setting_data[$result->key] = $result->value;
            } else {
                $setting_data[$result->key] = json_decode($result->value, true);
            }
        }

        return $setting_data;
    }
    public function getSetting($code) {
        $setting_data = array();

        $query = Settings::where('code',  $code)->get();

        foreach ($query as $result) {
            if (!$result->serialized) {
                $setting_data[$result->key] = $result->value;
            } else {
                $setting_data[$result->key] = json_decode($result->value, true);
            }
        }

        return $setting_data;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('settings::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post') ) {
           // dd('sda');
            $this->validate($request, [
               // 'config_site_logo' => 'bail|required',
                'config_site_title' => 'bail|required',
                //'config_about_us' => 'bail|required',
                //'config_copyright_text' => 'bail|required',
                //'logo' => $request->config_site_logo ? "" : 'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                //'config_email_host' => 'bail|required',
                //'config_email_encryption_type' => 'bail|required',
                //'config_email_port' => 'bail|required',
                //'config_email_username' => 'bail|required|email',
                //'config_email_from_address' => 'bail|required|email',
                //'config_email_from_name' => 'bail|required',
                //'config_email_password' => 'bail|required',
                'config_social_fb_url' => 'bail|nullable|url',
                'config_social_twitter_url' => 'bail|nullable|url',
                'config_social_instagram_url' => 'bail|nullable|url',
                'config_social_linkedin_url' => 'bail|nullable|url',
                'config_social_behance_url' => 'bail|nullable|url',

            ]);

           // if ($validator->passes()) {
              //  dd('ad');
                $logo_name = $request->config_site_logo;
                if ($request->hasFile('logo')) {
                    if (config('thumbnails.logo') . $request->config_site_logo) {
                        File::delete(config('thumbnails.logo') . $request->config_site_logo);
                    }
                    $logo_name = 'logo_' . time() . '.' . request()->logo->getClientOriginalExtension();
                    request()->logo->move(config('thumbnails.logo'), $logo_name);
                }
                $footer_logo_name = $request->config_footer_logo;
                if ($request->hasFile('footer_logo')) {
                    if (config('thumbnails.logo') . $request->config_footer_logo) {
                        File::delete(config('thumbnails.logo') . $request->config_footer_logo);
                    }
                    $footer_logo_name = 'footer_logo_' . time() . '.' . request()->footer_logo->getClientOriginalExtension();
                    request()->footer_logo->move(config('thumbnails.logo'), $footer_logo_name);
                }
                $favicon_name = $request->config_favicon;
                if ($request->hasFile('favicon')) {
                    if (config('thumbnails.logo') . $request->config_favicon) {
                        File::delete(config('thumbnails.logo') . $request->config_favicon);
                    }
                    $favicon_name = 'favicon_' . time() . '.' . request()->favicon->getClientOriginalExtension();
                    request()->favicon->move(config('thumbnails.logo'), $favicon_name);
                }
            $horizantal_banner = $request->config_horizantal_banner;
            if ($request->hasFile('horizantal_banner')) {
                if (config('thumbnails.logo') . $request->config_horizantal_banner) {
                    File::delete(config('thumbnails.logo') . $request->config_horizantal_banner);
                }
                $horizantal_banner = 'horizantal_banner_' . time() . '.' . request()->horizantal_banner->getClientOriginalExtension();
                request()->horizantal_banner->move(config('thumbnails.logo'), $horizantal_banner);
            }

            $footer_banner = $request->config_footer_banner;
            if ($request->hasFile('footer_banner')) {
                if (config('thumbnails.logo') . $request->config_footer_banner) {
                    File::delete(config('thumbnails.logo') . $request->config_footer_banner);
                }
                $footer_banner = 'footer_banner_' . time() . '.' . request()->footer_banner->getClientOriginalExtension();
                request()->footer_banner->move(config('thumbnails.logo'), $footer_banner);
            }


                $request->merge(['config_site_logo' => $logo_name]);
                $request->merge(['config_footer_logo' => $footer_logo_name]);
                $request->merge(['config_favicon' => $favicon_name]);
                $request->merge(['config_horizantal_banner' => $horizantal_banner]);
            $request->merge(['config_footer_banner' => $footer_banner]);
                $this->editSetting('config', $request);
                return redirect('admin/settings')
                    ->with('success','Settings updated successfully');

        }
    }
    public function editSetting($code, $request) {
        Settings::where('code', $code)->delete();
        foreach ($request->except(['logo']) as $key => $value) {
            if (!is_array($value)) {
                Settings::insert([
                    'code' => $code,
                    'key' => $key,
                    'value' => $value,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                Settings::insert([
                    'code' => $code,
                    'key' => $key,
                    'value' => json_encode($value, true),
                    'serialized' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
