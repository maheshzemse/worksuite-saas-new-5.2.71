<?php

namespace App\Http\Controllers\SuperAdmin\FrontSetting;

use App\Helper\Reply;
use App\Models\ThemeSetting;
use App\Models\GlobalSetting;
use App\Models\CompanyAddress;
use App\Models\SuperAdmin\GlobalCurrency;
use App\Models\SuperAdmin\FrontDetail;
use App\Http\Controllers\AccountBaseController;
use App\Http\Requests\SuperAdmin\ThemeSetting\UpdateRequest;

class ThemeSettingController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'superadmin.menu.frontThemeSettings';
        $this->activeSettingMenu = 'front_theme_settings';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->global      = GlobalSetting::first();
        $this->frontDetail = FrontDetail::first();
        $this->currencies  = GlobalCurrency::all();
        $this->superadminTheme = ThemeSetting::where('panel', 'superadmin')->first();
        $this->companyAddresses = CompanyAddress::all();

        return view('super-admin.front-setting.theme-setting.index', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function themeUpdate(UpdateRequest $request)
    {
        $global = GlobalSetting::first();
        $global->front_design = $request->theme;
        $global->frontend_disable = $request->has('frontend_disable') ? 1 : 0;
        $global->setup_homepage = $request->setup_homepage;
        $global->custom_homepage_url = $request->custom_homepage_url;

        if ($request->has('login_ui')) {
            $global->login_ui = $request->login_ui;
        }

        $global->save();

        $adminTheme = ThemeSetting::where('panel', 'superadmin')->first();
        $adminTheme->login_background = $request->logo_background_color;
        $adminTheme->enable_rounded_theme = $request->rounded_theme;
        $adminTheme->save();

        $setting = FrontDetail::first();
        $setting->locale = $request->default_language;

        if ($this->global->front_design == 0) {
            $setting->primary_color = $request->primary_color;
        }

        $setting->save();

        cache()->forget('global_setting');

        return Reply::successWithData(__('messages.updateSuccess'), ['redirectUrl' => route('superadmin.front-settings.front_theme_settings')]);

    }

}
