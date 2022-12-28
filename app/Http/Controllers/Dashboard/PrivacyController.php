<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\PrivacyCondetion;
use App\Models\PrivacyCondetionTranslation;
class PrivacyController extends Controller
{
    //
    public function edit(){
        $Privacy=PrivacyCondetion::find(1);
        return view('dashboard.PrivecyCondetion.edit',compact('Privacy'));
     }
     public function update(Request $request){
         try {
             DB::beginTransaction();
         $langs = array_keys(config('laravellocalization.supportedLocales'));
           foreach($langs as $lang){
            PrivacyCondetionTranslation::where('privecycondetion_id',1)->delete();
           }
           foreach($langs as $lang){
            PrivacyCondetionTranslation::create([
                  'privecycondetion_id'=>1,
                  'locale'=>$lang,
                  'desc'=>$request->$lang['desc']
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
