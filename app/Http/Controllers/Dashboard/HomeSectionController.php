<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\HomeSection;
use App\Models\HomeSectionTranslation;

use DB;

class HomeSectionController extends Controller
{
    //
    public function index(Request $request){
        $homesections=HomeSection::get();
        return view('dashboard.homesection.index',compact('homesections'));
    }
    public function create(Request $request){
        return view('dashboard.homesection.create');
    }
    public function store(Request $request){
        try {
           DB::beginTransaction();
            $langs = array_keys(config('laravellocalization.supportedLocales'));
            //validation
            $rules = [];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => 'required|unique:homesectiontranslations,name'];
                $rules += [$locale . '.desc' => 'required|unique:homesectiontranslations,desc'];
            }
            $rules += [
                'cover' => 'required|image',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation
            $cover_name = '';
            if ($request->hasFile('cover')) {
                # Upload New Image & Return its New Name
                $image_name = uploadImage($request->file('cover'), 'assets/images/homesection/');
                # Save New Name in DB
                $cover_name = $image_name;
            }
            //insert
            $homesection=HomeSection::create([
                'logo'=>$cover_name
            ]);
            foreach ($langs as $locale) {
                HomeSectionTranslation::create([
                  'home_section_id'=> $homesection->id,
                  'locale'=> $locale,
                  'name'=> $request->$locale['name'],
                  'desc'=> $request->$locale['desc'],
                ]);
            }
            //end of insert
           DB::commit();
            return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
    public function edit($id){
        $HomeSection = HomeSection::find($id);
        if (!$HomeSection)
        return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);
        return view('dashboard.homesection.edit', compact(['HomeSection']));
    }
    public function update(Request $request){
        try {
            DB::beginTransaction();
            $HomeSection = HomeSection::find($request->id);
            if ($request->hasFile('cover')) {
                # Upload New Image & Return its New Name
                $image_name = uploadImage($request->file('cover'), 'assets/images/homesection/');
                # Save New Name in DB
                $cover_name = $image_name;
                $HomeSection->update([
                    'logo'=>$cover_name,
                ]);
            }
            HomeSectionTranslation::where('home_section_id',$request->id)->delete();
            $langs = array_keys(config('laravellocalization.supportedLocales'));
            foreach ($langs as $locale) {
                HomeSectionTranslation::create([
                  'home_section_id'=> $HomeSection->id,
                  'locale'=> $locale,
                  'name'=> $request->$locale['name'],
                  'desc'=> $request->$locale['desc'],
                ]);
            }
            DB::commit();
            return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
    public function delete($id){
       HomeSection::find($id)->delete();
       return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
    }
}
