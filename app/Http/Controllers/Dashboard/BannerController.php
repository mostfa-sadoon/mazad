<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\BannerTranslation;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use File;

class BannerController extends Controller
{

    public function index(Request $request)
    {
        $banners = Banner::all();

        return view('dashboard.banners.index', compact(['banners']));
    }

    public function create()
    {
        return view('dashboard.banners.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            //validation
            $langs = array_keys(config('laravellocalization.supportedLocales'));
            $rules = [];
                foreach ($langs as $locale) {
                    $rules += [$locale . '.img' => 'required'];
                }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation
                $cover_name = '';
                //insert
                $banner=Banner::create([
                    'url'=>$request->url,
                    'type'=>$request->type,
                ]);
                if($request->hasFile('ar.img')&&$request->hasFile('en.img')) {
                    # Upload New Image & Return its New Name
                    foreach ($langs as $locale) {
                    $image_name = uploadImage($request->file($locale.'.img'), 'assets/images/banner/'.$locale);
                    # Save New Name in DB
                    $cover_name = $image_name;
                    BannerTranslation::create([
                        'banner_id'=>$banner->id,
                        'locale'=>$locale,
                        'img'=>$image_name,
                    ]);
                  }
                }
            DB::commit();
            return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }


    public function edit($id)
    {
        $banner = Banner::find($id);
        if (!$banner)
            return redirect()->route('admin.banners')->with(['error' => 'هذا الاسلايدر غير موجود']);

        return view('dashboard.banners.edit', compact(['banner']));
    }

    public $oldimgs=[];
    public function update(Request $request)
    {
       // dd($request->all());

        try {
            DB::beginTransaction();
             $id=$request->id;
            // $slider = Slider::find($id);
            // if (!$slider)
            //     return redirect()->route('admin.slider')->with(['error' => 'هذا الاسلايدر غير موجود']);

            //validation
            $langs = array_keys(config('laravellocalization.supportedLocales'));
            $rules = [];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            // return $request;
            //end of validation
            $banner=Banner::find($id);
            $banner->update([
               'url'=>$request->url,
               'type'=>$request->type,
            ]);

             foreach($langs as $lang){
                if($request->hasFile($lang.'.img')) {
                    $bannertrans=BannerTranslation::where('banner_id',$banner->id)->where('locale',$lang)->first();

                    array_push($this->oldimgs,$bannertrans->img);
                    $bannertrans->delete();
                    $image_name = uploadImage($request->file($lang.'.img'), 'assets/images/banner/'.$lang);
                    BannerTranslation::create([
                        'banner_id'=>$banner->id,
                        'locale'=>$lang,
                        'img'=>$image_name,
                    ]);
                }
             }
            DB::commit();
            foreach($langs as $lang){
                foreach($this->oldimgs as $oldimg){
                    $image_path='assets/images/banner/'.$lang.'/'.$oldimg;
                        if(File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
            return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }

    public function activation(Request $request){
        // try {
            $id=$request->id;
            $banner=Banner::find($id);
            if (!$banner)
            return redirect()->route('admin.banners')->with(['error' => 'هذا الاسلايدر غير موجود']);
            if($banner->activation==false){
                $banner->update(['activation'=>true]);
            }else{
                $banner->update(['activation'=>false]);
            }
             return response()->json($banner);
        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        // }
    }



    public function destroy($id)
    {
        try {
            $banner=Banner::find($id);
            if (!$banner)
                return redirect()->route('admin.banners')->with(['error' => 'هذا الاسلايدر غير موجود']);

            $banner->delete();
            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
