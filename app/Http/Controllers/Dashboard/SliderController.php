<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SliderController extends Controller
{

    public function index(Request $request)
    {

        $slider = Slider::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);


        return view('dashboard.slider.index', compact(['slider']));
    }


    public function create()
    {
        return view('dashboard.slider.create');
    }


    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            //validation
            $rules = [
                'image' => 'required|image',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            $cover_name = '';
            if ($request->hasFile('image')) {
                # Upload New Image & Return its New Name
                $image_name = uploadImage($request->file('image'), 'assets/images/sliders/');
                # Save New Name in DB
                $cover_name = $image_name;
            }

            //insert
            $slider = new Slider();
            $slider->image            = $cover_name;
            $slider->url = $request->url;
            $slider->save();

            DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }


    public function edit($id)
    {
        $slider = Slider::find($id);
        if (!$slider)
            return redirect()->route('admin.slider')->with(['error' => 'هذا الاسلايدر غير موجود']);

        return view('dashboard.slider.edit', compact(['slider']));
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $slider = Slider::find($id);
            if (!$slider)
                return redirect()->route('admin.slider')->with(['error' => 'هذا الاسلايدر غير موجود']);

            //validation
            $rules = [
                'image' => 'nullable|image',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            $cover_name = $slider->getAttributes()['image'];
            if ($request->hasFile('image')) {
                # Delete Old Image
                deleteFile($cover_name, 'assets/images/sliders/');
                # Upload New Image & Return its New Name
                $image_name = uploadImage($request->file('image'), 'assets/images/sliders/');
                # Save New Name in DB
                $cover_name = $image_name;
            }

            //Update
            $slider->image            = $cover_name;
            $slider->url = $request->url;
            $slider->save();

            DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
            $slider = Slider::find($id);
            if (!$slider)
                return redirect()->route('admin.slider')->with(['error' => 'هذا الاسلايدر غير موجود']);

            $slider->delete();

            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
