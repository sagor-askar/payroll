<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class settingController extends Controller
{
    public function edit() 
    {
       $settings =  Settings::orderBy('id','DESC')->first();
        return view('admin.settings.edit',compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $setting = Settings::orderBy('id','DESC')->first();
        $setting->update($data);

        $image = $request->company_logo;
        if($request->file('company_logo')){
            $file=$request->file('company_logo');
            $filename=date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('images/settings/'),$filename);
            $setting->company_logo = $filename;
            $setting->save();
        }
  
        return back();
    }
}
