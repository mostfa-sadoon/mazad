<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeTranslation;
use App\Models\Category;
use App\Models\SubAttribute;
use App\Models\SubAttributeTranslation;
use App\Rules\AttributeSubAttributeUniqueName;
use App\Rules\CategoryAttributeUniqueName;
use App\Rules\MarketAttributeUniqueName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Validator;

class SubAttributesController extends Controller
{

    public function index($attribute_id, Request $request)
    {
        // return $attribute_id;
        $attribute = Attribute::where(['id'=> $attribute_id , 'type'=> '0'])->first();
        if (!$attribute)
            return redirect()->back()->with(['error' => 'هذه الصفه غير موجوده ']);

        $sub_attributes = SubAttribute::where('attribute_id', $attribute_id)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        // return $sub_attributes;
        return view('dashboard.sub_attributes.index', compact(['sub_attributes', 'attribute']));
    }

    public function create($attribute_id)
    {
        $attribute = Attribute::where(['id'=> $attribute_id , 'type'=> '0'])->first();
        if (!$attribute)
            return redirect()->back()->with(['error' => 'هذه الصفه غير موجوده ']);

        // return $category;
        return view('dashboard.sub_attributes.create', compact(['attribute']));
    }

    public function store($attribute_id, Request $request)
    {
        // return $request;
        try {
            $langs = array_keys(config('laravellocalization.supportedLocales'));

            $attribute = Attribute::where(['id'=> $attribute_id , 'type'=> '0'])->first();
            if (!$attribute)
                return redirect()->back()->with(['error' => 'هذه الصفه غير موجوده ']);

            //validation
            $rules = [];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => ["required", new AttributeSubAttributeUniqueName($request->$locale['name'], $attribute_id)]];
            } //end of for each

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            DB::beginTransaction();

            //insert
            $sub_attr = new SubAttribute();
            $sub_attr->attribute_id = $attribute_id;
            $sub_attr->save();

            foreach ($langs as $locale) {
                $sub_attr_trans = new SubAttributeTranslation();
                $sub_attr_trans->sub_attribute_id = $sub_attr->id;
                $sub_attr_trans->locale = $locale;
                $sub_attr_trans->name = $request->$locale['name'];
                $sub_attr_trans->save();
            }
            //end of insert

            DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }


    public function edit($attribute_id, $id)
    {
        $sub_attribute = SubAttribute::find($id);
        if (!$sub_attribute)
            return redirect()->back()->with(['error' => 'هذه الصفه غير موجوده ']);

        return view('dashboard.sub_attributes.edit', compact('sub_attribute'));
    }


    public function update(Request $request, $attribute_id, $id)
    {
        try {
            DB::beginTransaction();
            $langs = array_keys(config('laravellocalization.supportedLocales'));

            $sub_attribute = SubAttribute::find($id);
            if (!$sub_attribute)
                return redirect()->back()->with(['error' => 'هذه الصفه غير موجوده ']);

            //validation
            $rules = [];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => ["required", new AttributeSubAttributeUniqueName($request->$locale['name'], $attribute_id , $sub_attribute->id)]];
            } //end of for each

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            //update DB

            //update translations
            foreach ($langs as $locale) {
                SubAttributeTranslation::where('locale', $locale)
                    ->where('sub_attribute_id', $sub_attribute->id)
                    ->update([
                        'name' => $request->$locale['name']
                    ]);
            }
            //end of update

            DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }


    public function destroy($attribute_id, $id)
    {
        try {
            DB::beginTransaction();

            $attribute = SubAttribute::find($id);

            if (!$attribute)
                return redirect()->back()->with(['error' => 'الصفه الفرعيه غير موجوده']);

            $attribute->delete();

            DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
