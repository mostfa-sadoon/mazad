<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Models\Quetion;
use App\Models\QuetionTranslation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class QuetionController extends Controller
{
    //
    public function index(){
     $quetions=Quetion::get();
     return view('dashboard.quetion.index',compact('quetions'));
    }
    public function create(){
        return view('dashboard.quetion.create');
    }
    public function store(Request $request){
        try {

        DB::beginTransaction();
        $rules = [];
        $langs = array_keys(config('laravellocalization.supportedLocales'));
        foreach ($langs as $locale) {
            $rules += [$locale . '.quetion' => 'required|unique:quetionstranslations,quetion'];
            $rules += [$locale . '.answer' => 'required|unique:quetionstranslations,answer'];
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $quetion=Quetion::create();
        foreach($langs as $lang){
            QuetionTranslation::create([
              'quetion_id'=>$quetion->id,
              'locale'=> $lang,
              'quetion'=> $request->$locale['quetion'],
              'answer'=> $request->$locale['answer'],
            ]);
        }
        DB::commit();
        return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
    public function edit($id){
        $quetion = Quetion::find($id);
        if (!$quetion)
        return redirect()->back()->with(['error' => 'هذا ألسؤال غير موجود ']);
        return view('dashboard.quetion.edit', compact(['quetion']));
    }
    public function update(Request $request){
        try {
            DB::beginTransaction();
            $quetion = Quetion::find($request->id);
            QuetionTranslation::where('quetion_id',$request->id)->delete();
            $langs = array_keys(config('laravellocalization.supportedLocales'));
            foreach ($langs as $locale) {
                QuetionTranslation::create([
                  'quetion_id'=> $quetion->id,
                  'locale'=> $locale,
                  'quetion'=> $request->$locale['quetion'],
                  'answer'=> $request->$locale['answer'],
                ]);
            }
            DB::commit();
            return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
    public function desstroy($id){
        Quetion::find($id)->delete();
        return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
    }
}
