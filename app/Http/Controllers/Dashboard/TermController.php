<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\TermTranslation;
use DB;

class TermController extends Controller
{
    //
    public function edit(){
       $term=Term::find(1);
       return view('dashboard.terms.edit',compact('term'));
    }
    public function update(Request $request){
        try {
            DB::beginTransaction();
        $langs = array_keys(config('laravellocalization.supportedLocales'));
          foreach($langs as $lang){
            TermTranslation::where('term_id',1)->delete();
          }
          foreach($langs as $lang){
            TermTranslation::create([
                 'term_id'=>1,
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
