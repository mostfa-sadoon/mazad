<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeTranslation;
use App\Models\Category;
use App\Rules\CategoryAttributeUniqueName;
use App\Rules\MarketAttributeUniqueName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Validator;

class AttributesController extends Controller
{

    public function index($category_id, Request $request)
    {
        // $category = Category::where('id', $category_id)->where('parent_id', '<>', null)->first();
        $category = Category::where('id', $category_id)->first();
        if (!$category)
            return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);

        $attributes = Attribute::where('category_id', $category_id)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        // return $attributes;
        return view('dashboard.attributes.index', compact(['attributes', 'category']));
    }

    public function create($category_id)
    {
        // $category = Category::where('id', $category_id)->where('parent_id', '<>', null)->first();
        $category = Category::where('id', $category_id)->first();
        if (!$category)
            return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);

        // return $category;
        return view('dashboard.attributes.create', compact(['category']));
    }

    public function store($category_id, Request $request)
    {
        // return $request;
        try {
            $langs = array_keys(config('laravellocalization.supportedLocales'));

            // $category = Category::where('id', $category_id)->where('parent_id', '<>', null)->first();
            $category = Category::where('id', $category_id)->first();
            if (!$category)
                return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);

            //validation
            $rules = ['type' => 'required|numeric|in:0,1,2'];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => ["required", new CategoryAttributeUniqueName($request->$locale['name'], $category_id)]];
            } //end of for each

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            DB::beginTransaction();

            //insert
            $attr = new Attribute();
            $attr->category_id = $category_id;
            $attr->type = $request->type;
            $attr->save();

            foreach ($langs as $locale) {
                $attr_trans = new AttributeTranslation();
                $attr_trans->attribute_id = $attr->id;
                $attr_trans->locale = $locale;
                $attr_trans->name = $request->$locale['name'];
                $attr_trans->save();
            }
            //end of insert

            DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }


    public function edit($category_id, $id)
    {
        // $category = Category::where('id', $category_id)->where('parent_id', '<>', null)->first();
        $category = Category::where('id', $category_id)->first();
        if (!$category)
            return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);

        $attribute = Attribute::find($id);

        if (!$attribute)
            return redirect()->back()->with(['error' => 'هذه الصفه غير موجوده ']);

        return view('dashboard.attributes.edit', compact('attribute'));
    }


    public function update(Request $request, $category_id, $id)
    {
        try {
            DB::beginTransaction();
            $langs = array_keys(config('laravellocalization.supportedLocales'));

            $attribute = Attribute::find($id);
            if (!$attribute)
                return redirect()->back()->with(['error' => 'هذه الصفه غير موجوده ']);

            // $category = Category::where('id', $category_id)->where('parent_id', '<>', null)->first();
            $category = Category::where('id', $category_id)->first();
            if (!$category)
                return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);

            //validation
            $rules = ['type' => 'required|numeric|in:0,1,2'];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => ["required", new CategoryAttributeUniqueName($request->$locale['name'], $category_id , $attribute->id)]];
            } //end of for each

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation

            //update DB
            $attribute->type = $request->type;
            $attribute->save();

            //update translations
            foreach ($langs as $locale) {
                AttributeTranslation::where('locale', $locale)
                    ->where('attribute_id', $attribute->id)
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


    public function destroy($category_id, $id)
    {
        try {
            DB::beginTransaction();

            $attribute = Attribute::find($id);

            if (!$attribute)
                return redirect()->back()->with(['error' => 'هذه الصفه غير موجوده ']);

            $attribute->delete();

            DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
