<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CitiesController extends Controller
{

    public function index(Request $request)
    {

        $cities = City::when($request->city_search_input, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->city_search_input . '%');
        })->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);


        return view('dashboard.cities.index', compact(['cities']));
    }


    public function create()
    {
        $categories = Country::all();
        return view('dashboard.cities.create', compact(['categories']));
    }


    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $langs = array_keys(config('laravellocalization.supportedLocales'));

            //validation
            $rules = [
                'country_id' => 'required|exists:countries,id',
            ];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => 'required|unique:city_translations,name'];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            //insert
            $city = new City();
            $city->country_id = $request->country_id;
            $city->save();

            foreach ($langs as $locale) {
                $city_trans = new CityTranslation();
                $city_trans->city_id = $city->id;
                $city_trans->locale = $locale;
                $city_trans->name = $request->$locale['name'];
                $city_trans->save();
            } //end of for each

            DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }


    public function edit($id)
    {
        $city = City::find($id);
        if (!$city)
            return redirect()->route('admin.cities')->with(['error' => 'هذه المدينه غير موجوده']);

        $categories = Country::all();

        return view('dashboard.cities.edit', compact(['city' , 'categories']));
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $city = City::find($id);
            if (!$city)
                return redirect()->route('admin.cities')->with(['error' => 'هذه المدينه غير موجوده']);

            $langs = array_keys(config('laravellocalization.supportedLocales'));

            //validation
            $rules = [
                'country_id' => 'required|exists:countries,id',
            ];
            foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
                $rules += [$locale . '.name' => ['required', Rule::unique('city_translations', 'name')->ignore($city->id, 'city_id')]];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            //Update
            $city->country_id = $request->country_id;
            $city->save();

            //Update translations
            foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
                CityTranslation::where('locale', $locale)
                    ->where('city_id', $city->id)
                    ->update([
                        'name' => $request->$locale['name']
                    ]);
            }

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
            $city = City::find($id);
            if (!$city)
                return redirect()->route('admin.cities')->with(['error' => 'هذه المدينه غير موجوده']);

            $city->delete();

            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
