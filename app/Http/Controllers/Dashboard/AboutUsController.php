<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\AboutUsTranslation;
use DB;
class AboutUsController extends Controller
{
    //
    public function edit(){
       $aboutus=AboutUs::find(1);
       return view('dashboard.aboutus.edit',compact('aboutus'));
    }
    public function update(Request $request){
        try {
            DB::beginTransaction();
        $langs = array_keys(config('laravellocalization.supportedLocales'));
          foreach($langs as $lang){
            AboutUsTranslation::where('about_us_id',1)->delete();
          }
          foreach($langs as $lang){
            AboutUsTranslation::create([
                 'about_us_id'=>1,
                 'locale'=>$lang,
                 'name'=>$request->$lang['name']
            ]);
          }
        DB::commit();
        return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
        return redirect()->back();
    }
}
