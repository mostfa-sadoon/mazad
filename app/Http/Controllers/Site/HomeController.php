<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Category;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Banner;
use App\Models\HomeSection;
use App\Models\Logo;
use Illuminate\Support\Facades\Validator;
use Config;
Use Session;
use Auth;
class HomeController extends Controller
{


  public function index(Request $request)
  {
    $carbon_now = Carbon::now();
    $now = $carbon_now->toDateTimeString();
    $country_id = 0;

    if ($request->country_id){
      $country_id = $request->country_id;
      if(Auth::guard('client')->check()){
      Auth::guard('client')->user()->update(['country_id'=>$request->country_id]);
      }
      Session(['country_id'=>$country_id]);
    }else{
        if (auth('client')->check()) {
            $country_id = auth('client')->user()->country_id;
            Session(['country_id'=>$country_id]);
        }else{

            if(Session::get('country_id')==null){
                $country_id = firstCountry()->id;
                Session(['country_id'=>$country_id]);
            }
        }
    }


    $country_id=Session::get('country_id');
    // return $country_id;
    // $q = Auction::with(['city', 'city.country']);
    $data['slider'] = Slider::select('id', 'image','url')->where('place', 1)->get();
    $data['down_slider'] = Slider::select('id', 'image','url')->where('place', 2)->first();
    $data['categories'] = getCategories();
    $data['latest_auctions'] = Auction::with(['city', 'city.country'])->where(
      function ($q) use ($carbon_now, $now) {
        return $q->where([
          ['created_at', '>=', $carbon_now->subdays(30)->toDateTimeString()],
          ['status', null],
          ['status','!=',1],
          ['status','!=',2],
          ['status','!=',4],
          ['start_date', '<', $now]
        ])
          ->orWhere([
            ['created_at', '>=', $carbon_now->subdays(30)->toDateTimeString()],
            ['status', 3]
          ]);
      }
    )->where('country_id', $country_id)->orderBy('id' , 'desc')->limit(PAGINATION_COUNT)->get();


    $data['soon_actions'] = Auction::with(['city', 'city.country'])->where('start_date', '>', $now)->where('country_id', $country_id)->orderBy('id' , 'desc')->limit(PAGINATION_COUNT)->get();
    // $not_ended_auctions = $q->where('end_date', '>=', $carbon_now)->where('country_id', $country_id)->get();
    // foreach ($not_ended_auctions as $key => $auction) {
    //   $auction_end_datetime = $auction->end_date . ' ' . $auction->end_time;
    //   $end_date = Carbon::parse($auction_end_datetime)->toDateTimeString();
    //   $required_date_zone = Carbon::parse($auction_end_datetime)->subdays(2)->toDateTimeString();
    //   if ($end_date >= $now && $required_date_zone <= $now) {
    //     if (count($data['soon_actions']) == PAGINATION_COUNT) {
    //       break;
    //     }
    //     $data['soon_actions'][] = $auction;
    //   }
    // }

    $homeSections=HomeSection::get();
    $data['homeSections']=$homeSections;
    $data['closed_auctions'] = Auction::with(['city', 'city.country'])->where([
      ['end_date', '<', $carbon_now->toDateString()],
      ['end_time', '<', $carbon_now->toTimeString()]
    ])->orWhereIn('status', [1, 2])->where('country_id', $country_id)->orderBy('id' , 'desc')->limit(PAGINATION_COUNT)->get();
   //$banners=Banner::get();
   $sidebarbanners=Banner::where('type','sidebar')->where('activation',true)->get();
   $mainbanners=Banner::where('type','main')->where('activation',true)->get();
   $data['sidebarbanners']=$sidebarbanners;
   $data['mainbanners']=$mainbanners;


    return view('front.home')->with($data)->with(['country_id' => $country_id]);
  }

}
