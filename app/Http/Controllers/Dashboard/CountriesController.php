<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
use App\Models\CountryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CountriesController extends Controller
{

    public function index(Request $request)
    {

        $countries = Country::when($request->search_input, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->search_input . '%');
        })->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);


        return view('dashboard.countries.index', compact(['countries']));
    }


    public function create()
    {
        return view('dashboard.countries.create');
    }


    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $langs = array_keys(config('laravellocalization.supportedLocales'));

            //validation
            $rules = [
                'currency' => 'required|string',
                'image' => 'required|image',
            ];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => 'required|unique:country_translations,name'];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            $cover_name = '';
            if ($request->hasFile('image')) {
                # Upload New Image & Return its New Name
                $image_name = uploadImage($request->file('image'), 'assets/images/countries/');
                # Save New Name in DB
                $cover_name = $image_name;
            }

            //insert
            $country = new Country();
            $country->currency = $request->currency;
            $country->image            = $cover_name;
            $country->save();

            foreach ($langs as $locale) {
                $country_trans = new CountryTranslation();
                $country_trans->country_id = $country->id;
                $country_trans->locale = $locale;
                $country_trans->name = $request->$locale['name'];
                $country_trans->save();
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
        $country = Country::find($id);
        if (!$country)
            return redirect()->route('admin.cities')->with(['error' => 'هذه الدوله غير موجوده']);

        return view('dashboard.countries.edit', compact(['country']));
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $country = Country::find($id);
            if (!$country)
                return redirect()->route('admin.cities')->with(['error' => 'هذه الدوله غير موجوده']);

            $langs = array_keys(config('laravellocalization.supportedLocales'));

            //validation
            $rules = [
                'image' => 'nullable|image',
                'currency' => 'required|string',
            ];
            foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
                $rules += [$locale . '.name' => ['required', Rule::unique('country_translations', 'name')->ignore($country->id, 'country_id')]];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            $cover_name = $country->getAttributes()['image'];
            if ($request->hasFile('image')) {
                # Delete Old Image
                deleteFile($cover_name, 'assets/images/categories/');
                # Upload New Image & Return its New Name
                $image_name = uploadImage($request->file('image'), 'assets/images/countries/');
                # Save New Name in DB
                $cover_name = $image_name;
            }

            //Update
            $country->currency = $request->currency;
            $country->image            = $cover_name;
            $country->save();

            //Update translations
            foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
                CountryTranslation::where('locale', $locale)
                    ->where('country_id', $country->id)
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
            $country = Country::find($id);
            if (!$country)
                return redirect()->route('admin.cities')->with(['error' => 'هذه الدوله غير موجوده']);

            $country->delete();

            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
