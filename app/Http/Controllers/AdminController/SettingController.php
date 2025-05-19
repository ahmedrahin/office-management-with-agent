<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $setting = Settings::first();
        return view('backend.pages.settings.manage', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $setting = Settings::find(1);

        // logo
        if ($request->logo) {
            // logo
            if (File::exists($setting->logo)) {
                File::delete($setting->logo);
            }

            $thumbImage = $request->file('logo');
            $thumbImageName = time() . '_' . $thumbImage->getClientOriginalName();
            $thumbImage->move(public_path('/backend/images'), $thumbImageName);
            $image = '/backend/images/' . $thumbImageName;

            $setting->logo = $image;
        }

        // fav icon
        if ($request->fav) {
            // logo
            if (File::exists($setting->fav)) {
                File::delete($setting->fav);
            }

            $thumbImage = $request->file('fav');
            $thumbImageName = time() . '_' . $thumbImage->getClientOriginalName();
            $thumbImage->move(public_path('/backend/images'), $thumbImageName);
            $image = '/backend/images/' . $thumbImageName;

            $setting->fav_icon = $image;
        }

        $setting->company_name = $request->name;
        $setting->email1 = $request->email1;
        $setting->email2 = $request->email2;
        $setting->phone1 = $request->phone1;
        $setting->phone2 = $request->phone2;
        $setting->address = $request->address;
        $setting->city = $request->city;
        $setting->zip = $request->zip;

        $setting->save();

    }

}
