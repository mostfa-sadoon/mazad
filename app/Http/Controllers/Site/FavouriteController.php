<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuctionRequest;
use App\Models\Auction;
use App\Models\AuctionImage;
use App\Models\Biding;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Favourite;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FavouriteController extends Controller
{


  public function index()
  {
    try {
      $auctions = Auction::with(['city', 'city.country'])->join('favourits' , 'favourits.auction_id' , 'auctions.id')
      ->select('auctions.*' , 'favourits.client_id as favourits_client_id')
      ->where(['favourits.client_id' => auth('client')->id()])
      ->paginate(PAGINATION_COUNT);
      
      // return $auctions;

      return view('front.favourits' , compact(['auctions']));

    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }

  public function addToFavourite($id)
  {
    // return $id;
    try {
      $client_id = auth('client')->id();

      $client_favourite = Favourite::where(['auction_id' => $id, 'client_id' => $client_id])->first();

      if (!$client_favourite) {
        $auction = Auction::find($id);
        if (!$auction)
          return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);

        $new_fav = new Favourite();
        $new_fav->auction_id = $id;
        $new_fav->client_id = $client_id;
        $new_fav->save();
        return redirect()->back()->with(['success_model' => __('app/all.You_have_been_added_this_auction_to_your_favourits')]);
      } else {
        $client_favourite->delete();
        return redirect()->back()->with(['success_model' => __('app/all.You_have_been_deleted_this_auction_from_your_favourits')]);
      }
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }
}
