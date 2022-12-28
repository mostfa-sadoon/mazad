<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
use App\Models\Recognition;
use App\Models\RecognitionTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RecognitionsController extends Controller
{

    public function index(Request $request)
    {

        $recognitions = Recognition::when($request->search_input, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->search_input . '%');
        })->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);


        return view('dashboard.recognitions.index', compact(['recognitions']));
    }


    public function create()
    {
        return view('dashboard.recognitions.create');
    }


    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $langs = array_keys(config('laravellocalization.supportedLocales'));

            //validation
            $rules = [
                'days' => 'required|numeric',
                'price' => 'required|numeric',
            ];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => 'required|unique:recognition_translations,name'];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            //insert
            $recognition = new Recognition();
            $recognition->days = $request->days;
            $recognition->price = $request->price;
            $recognition->save();

            foreach ($langs as $locale) {
                $recognition_trans = new RecognitionTranslation();
                $recognition_trans->recognition_id = $recognition->id;
                $recognition_trans->locale = $locale;
                $recognition_trans->name = $request->$locale['name'];
                $recognition_trans->save();
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
        $recognition = Recognition::find($id);
        if (!$recognition)
            return redirect()->route('admin.recognitions')->with(['error' => 'هذه الباقه غير موجوده']);


        return view('dashboard.recognitions.edit', compact(['recognition']));
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $recognition = Recognition::find($id);
            if (!$recognition)
                return redirect()->route('admin.recognitions')->with(['error' => 'هذه الباقه غير موجوده']);

            $langs = array_keys(config('laravellocalization.supportedLocales'));

            //validation
            $rules = [
                'days' => 'required|numeric',
                'price' => 'required|numeric',
            ];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => ['required', Rule::unique('recognition_translations', 'name')->ignore($recognition->id, 'recognition_id')]];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            //Update
            $recognition->days = $request->days;
            $recognition->price = $request->price;
            $recognition->save();

            //Update translations
            foreach ($langs as $locale) {
                RecognitionTranslation::where('locale', $locale)
                    ->where('recognition_id', $recognition->id)
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
            $recognition = Recognition::find($id);
            if (!$recognition)
                return redirect()->route('admin.recognitions')->with(['error' => 'هذه الباقه غير موجوده']);

            $recognition->delete();

            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
