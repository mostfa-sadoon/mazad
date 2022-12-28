<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Category;
use App\Models\City;
use App\Models\Favourite;
use App\Models\Slider;
use Carbon\Carbon;
use App\Models\Banner;
Use Session;
class AuctionsController extends Controller
{


  public function index(Request $request)
  {


    $old_cat_id = $request->category_id ?? 0;
    if ($request->sub_category_id && $request->sub_category_id != null) {
      $old_cat_id = $request->category_id;
      $request->category_id = $request->sub_category_id;
    }

    $carbon_now = Carbon::now();
    $now = $carbon_now->toDateTimeString();

    $country_id = 0;
    if (auth('client')->check())
    $country_id = auth('client')->user()->country_id;
    if(Session::get('country_id')==null){
        $country_id = firstCountry()->id;
        Session(['country_id'=>$country_id]);
    }else{
        $country_id=Session::get('country_id');
    }
    if(Session::get('country_id')==null){
        $country_id = firstCountry()->id;
        Session(['country_id'=>$country_id]);
    }    // return $country_id;

    $query = Auction::with(['city', 'city.country', 'bidings' => function ($q) {
      return $q->orderBy('value', 'desc');
    }])->where('country_id', $country_id);

    $data['auctions'] = [];

    $data['categories'] =   Category::where('parent_id', null)
      // when($request->category_id, function ($q) use ($request) {
      //   return $q->where('parent_id', '<>', null);
      // })
      // ->when(!$request->category_id, function ($q) use ($request) {
      //   return $q->where('parent_id', '<>', null);
      // })
      ->orderBy('id', 'DESC')->get();
    // where('parent_id', '<>', null)->orderBy('id', 'DESC')->get();

    $data['sub_categories'] =   Category::where('parent_id', $old_cat_id)
      ->orderBy('id', 'DESC')->get();
    // return count($data['sub_categories']);

    $data['cities'] =   City::where('country_id', $country_id)->orderBy('id', 'DESC')->get();

    $data['marked_auctions'] = Auction::with(['city', 'city.country'])->where('country_id', $country_id)->where('recognition_end_date', '>=', Carbon::now()->toDateTimeString())
      ->when($request->category_id, function ($q) use ($request) {
        return $q->whereIn('category_id', $this->categoryType($request->category_id));
      })
      ->when($request->city_id, function ($q) use ($request) {
        return $q->where('city_id', $request->city_id);
      });
    // return $data['marked_auctions'];



    if ($request->auction_type && $request->auction_type == 1) {
      $data['marked_auctions'] = $data['marked_auctions']->where(
        function ($q) use ($carbon_now, $now) {
          return $q->where([
            ['created_at', '>=', $carbon_now->subdays(3)->toDateTimeString()],
            ['status', null],
            ['start_date', '<', $now]
          ])
            ->orWhere([
              ['created_at', '>=', $carbon_now->subdays(3)->toDateTimeString()],
              ['status', 3]
            ]);
        }
      )->orderBy('id', 'desc')->get();

      $data['auctions'] = $query->where(
        function ($q) use ($carbon_now, $now) {
          return $q->where([
            ['created_at', '>=', $carbon_now->subdays(3)->toDateTimeString()],
            ['status', null],
            ['start_date', '<', $now]
          ])
            ->orWhere([
              ['created_at', '>=', $carbon_now->subdays(3)->toDateTimeString()],
              ['status', 3]
            ]);
        }
      )
        ->when($request->category_id, function ($q) use ($request) {
          return $q->whereIn('category_id', $this->categoryType($request->category_id));
        })
        ->when($request->city_id, function ($q) use ($request) {
          return $q->where('city_id', $request->city_id);
        })->when($request->search_input, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search_input . '%');
        })->orderBy('id', 'desc')->paginate(PAGINATION_COUNT);
    } elseif ($request->auction_type && $request->auction_type == 2) {

      $data['marked_auctions'] = $data['marked_auctions']->where('start_date', '>', $now)->orderBy('id', 'desc')->get();

      $data['auctions'] = $query->where('start_date', '>', $now)->orderBy('id', 'desc')->paginate(PAGINATION_COUNT);
    } elseif ($request->auction_type && $request->auction_type == 3) {

      $data['marked_auctions'] = $data['marked_auctions']->where([
        ['end_date', '<', $carbon_now->toDateString()],
        ['end_time', '<', $carbon_now->toTimeString()]
      ])->orWhereIn('status', [1, 2])
        ->when($request->category_id, function ($q) use ($request) {
          return $q->whereIn('category_id', $this->categoryType($request->category_id));
        })->when($request->search_input, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search_input . '%');
        })
        ->orderBy('id', 'desc')->get();

      $data['auctions'] = $query->where([
        ['end_date', '<', $carbon_now->toDateString()],
        ['end_time', '<', $carbon_now->toTimeString()]
      ])->orWhereIn('status', [1, 2])
        ->when($request->category_id, function ($q) use ($request) {
          return $q->whereIn('category_id', $this->categoryType($request->category_id));
        })
        ->when($request->city_id, function ($q) use ($request) {
          return $q->where('city_id', $request->city_id);
        })->when($request->search_input, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search_input . '%');
        })
        ->orderBy('id', 'desc')->paginate(PAGINATION_COUNT);
    }else{
      $data['marked_auctions'] = $data['marked_auctions']->orderBy('id', 'desc')->get();
      $data['auctions'] = $query
        ->when($request->category_id, function ($q) use ($request) {
          return $q->whereIn('category_id', $this->categoryType($request->category_id));
        })
        ->when($request->city_id, function ($q) use ($request) {
          return $q->where('city_id', $request->city_id);
        })->when($request->search_input, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search_input . '%');
        })->orderBy('id', 'desc')->paginate(PAGINATION_COUNT);
    }
    $search=false;
    if($request->search_input!=null)
    $search=true;
    // return $data['auctions'];
    return view('front.auctions')->with($data)->with(['category_id' => $old_cat_id, 'city_id' => $request->city_id, 'auction_type' => $request->auction_type, 'sub_category_id' => $request->sub_category_id,'search'=>$search]);
  }
  public function show($slug)
  {
    $data['auction'] = Auction::withCount(['bidings'])->with(['images', 'city', 'city.country', 'category', 'features', 'features.attribute', 'features.sub_attribute', 'bidings' => function ($q) {
      return $q->orderBy('value', 'desc');
    }])->where('slug', $slug)->first();
    if (!$data['auction'])
      return redirect()->back()->with(['error' => 'Not found this auction']);

    $data['down_slider'] = Slider::select('id', 'image')->where('place', 2)->first();
    $data['interested_auctions'] = Auction::with(['city', 'city.country'])->where('category_id', $data['auction']->category_id)->limit(PAGINATION_COUNT)->get();

    $data['client_favourite'] = null;
    if (auth('client')) {
      $data['client_favourite'] = Favourite::select('id')->where(['auction_id' => $data['auction']->id, 'client_id' => auth('client')->id()])->first();
    }
    // return $data['auction'];
    $header_auctions=Banner::where('type','header_auctions')->where('activation',true)->get();
    $footer_auctions=Banner::where('type','footer_auctions')->where('activation',true)->get();
    $data['header_auctions']=$header_auctions;
    $data['footer_auctions']=$footer_auctions;
    return view('front.auction_info')->with($data);
  }


  function fetch(Request $request)
  {
    $value = $request->get('value');
    $items = [];

    $items = Category::where('parent_id', $value)->get();

    $output = '';

    if (count($items) == 0) {
      echo $output;
    } else {

      $output .= '<option value="">' . __("app/all.select_value") . '</option>';
      foreach ($items as $row) {
        $output .= '<option value="' . $row->id . '" >' . $row->name . '</option>';
      }
      // $output .= '</select>';

      echo $output;
    }
  }


  public function categoryType($id)
  {
    $ids = [];
    $category = Category::find($id);
    if ($category->parent_id == null) { #Parent category
      $ids = $category->childrens->pluck('id')->toArray();
      $ids[] = $category->id;
    } else { #Sub category
      $ids[] = $category->id;
    }
    return $ids;
  }
}
