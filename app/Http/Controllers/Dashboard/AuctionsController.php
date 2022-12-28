<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\Recognition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuctionsController extends Controller
{

    public function index(Request $request)
    {
        $carbon_now = Carbon::now();
        $now = $carbon_now->toDateTimeString();
        $auction_type = $request->auction_type;
        $search_input = $request->search_input ?? '';
        //$country_id=Session::get('country_id');
        $auctions = Auction::with(['city', 'city.country', 'category'])
            ->when($request->auction_type, function ($q) use ($request, $carbon_now, $now) {
                if ($request->auction_type == 1) {
                    return $q->where(
                        function ($q) use ($carbon_now, $now) {
                            return $q->where([
                                // ['created_at', '>=', $carbon_now->subdays(3)->toDateTimeString()],
                                ['status', null],
                                ['start_date', '<', $now],
                                ['end_date', '>', $carbon_now->toDateString()],
                                // ['end_time', '>', $carbon_now->toTimeString()],
                            ])
                                ->orWhere([
                                    // ['created_at', '>=', $carbon_now->subdays(3)->toDateTimeString()],
                                    ['status', 3]
                                ]);
                        }
                    );
                } elseif ($request->auction_type == 2) {
                    return $q->where('start_date', '>', $now);
                } elseif ($request->auction_type == 3) {
                    return $q->where([
                        ['end_date', '<', $carbon_now->toDateString()],
                        ['end_time', '<', $carbon_now->toTimeString()]
                    ])->orWhereIn('status', [1, 2]);
                }
            })->when($request->search_input, function ($q) use ($request) {
                return $q->where('name', 'like', '%' . $request->search_input . '%');
            })
            ->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
            return view('dashboard.auctions.index', compact(['auctions', 'auction_type', 'search_input']));
        }


    public function markPage($id)
    {
        $auction = Auction::find($id);
        if (!$auction)
            return redirect()->route('admin.auctions')->with(['error' => 'هذا المزاد غير موجود']);

        $recognitions = Recognition::all();

        return view('dashboard.auctions.mark', compact(['recognitions', 'auction']));
    }


    public function markAuction($id, Request $request)
    {
        // return $request;
        try {

            DB::beginTransaction();

            $auction = Auction::find($id);
            if (!$auction)
                return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);
            if ($auction->recognition_id != null)
                return redirect()->back()->with(['error' => __('app/all.marked_auction')]);

            $recognition = Recognition::find($request->recognition_id);
            if (!$recognition)
                return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);


            $auction->recognition_id = $recognition->id;
            $auction->recognition_start_date = Carbon::now();
            $auction->recognition_end_date = Carbon::now()->addDays($recognition->days);
            $auction->save();

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

        return view('dashboard.auctions.edit', compact(['country']));
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
            $auction = Auction::find($id);
            if (!$auction)
                return redirect()->route('admin.auctions')->with(['error' => 'هذا المزاد غير موجود']);

            $auction->delete();

            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
