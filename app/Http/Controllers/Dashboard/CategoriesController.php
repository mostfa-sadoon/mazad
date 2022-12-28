<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Rules\MarketCategoryUniqueName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('parent_id',null)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        $maincategory=true;
        return view('dashboard.categories.index', compact(['categories','maincategory']));
    }
    public function subcategories($id){
        $categories = Category::where('parent_id',$id)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        $maincategory=false;
        return view('dashboard.categories.index', compact(['categories','maincategory']));
    }
    public function create()
    {
        $categories =   Category::where('parent_id', null)
            ->select('id', 'parent_id')
            ->orderBy('id', 'DESC')
            ->get();
        return view('dashboard.categories.create', compact(['categories']));
    }
    public function store(Request $request)
    {

        try {

            DB::beginTransaction();

            $langs = array_keys(config('laravellocalization.supportedLocales'));

            //validation
            $rules = [];
            foreach ($langs as $locale) {
                $rules += [$locale . '.name' => 'required|unique:category_translations,name'];
            }
            $rules += [
                'cover' => 'required|image',
                'parent_id' => 'nullable|numeric|exists:categories,id'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            //end of validation
            $cover_name = '';
            if ($request->hasFile('cover')) {
                # Upload New Image & Return its New Name
                $image_name = uploadImage($request->file('cover'), 'assets/images/categories/');
                # Save New Name in DB
                $cover_name = $image_name;
            }
            //insert
            $category = new Category();
            $category->parent_id = $request->parent_id;
            $category->image = $cover_name;
            $category->save();

            foreach ($langs as $locale) {
                $category_trans = new CategoryTranslation();
                $category_trans->category_id = $category->id;
                $category_trans->locale = $locale;
                $category_trans->name = $request->$locale['name'];
                $category_trans->save();
            }
            //end of insert
            DB::commit();
            return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category)
        return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);
        $categories = Category::where('parent_id', null)
            ->where('id', '<>', $category->id)
            ->select('id', 'parent_id')
            ->orderBy('id', 'DESC')
            ->get();
        return view('dashboard.categories.edit', compact(['category', 'categories']));
    }
    public function update(Request $request , $id)
    {
        // try {
        //     DB::beginTransaction();

            $category = Category::find($id);
            if (!$category)
                return redirect()->back()->with(['error' => 'هذا القسم غير موجود']);

            //Validation
            $rules = [
                'cover' => 'nullable|image',
                'parent_id' => 'nullable|numeric|exists:categories,id'
            ];

            if ($request->has('parent_id') && $request->parent_id != '') {
                $rules += ['parent_id' => 'required|exists:categories,id'];
            }

            foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
                $rules += [$locale . '.name' => ['required' , Rule::unique('category_translations', 'name')->ignore($category->id, 'category_id')]
            ];
            } //end of for each

            $request->validate($rules);
            //End of Validation

            $cover_name = $category->getAttributes()['image'];
            if ($request->hasFile('cover')) {
                # Delete Old Image
                deleteFile($cover_name, 'assets/images/categories/');
                # Upload New Image & Return its New Name
                $image_name = uploadImage($request->file('cover'), 'assets/images/categories/');
                # Save New Name in DB
                $cover_name = $image_name;
            }

            $category->parent_id        = $request->parent_id;
            $category->image            = $cover_name;
            $category->save();


            //update translations
            foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
                CategoryTranslation::where('locale', $locale)
                    ->where('category_id', $category->id)
                    ->update([
                        'name' => $request->$locale['name']
                    ]);
            }
            //end of update

            // DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        // }
    }


    public function destroy($id)
    {
        // return $id;
        try {
            DB::beginTransaction();

            $category = Category::find($id);

            if (!$category)
                return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);

            $category->delete();

            DB::commit();

            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
