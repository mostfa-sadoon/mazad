<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuctionRequest;
use App\Http\Services\NotificationService;
use App\Models\Auction;
use App\Models\AuctionFeature;
use App\Models\AuctionImage;
use App\Models\Biding;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Recognition;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuctionController extends Controller
{
  public function create(Request $request)
  {
    $category_id = 0;
    if ($request->category_id) {
      $category_id = $request->category_id;
    }
    if ($request->sub_category_id) {
       $category_id = $request->sub_category_id;
       $category=Category::with('childrens')->find($request->category_id);
       if($category->childrens->count()==0)
       $category_id=$request->category_id;
    }
    $category = Category::find($category_id);
    if (!$category)
      return redirect()->back()->with(['error' => __('app/all.Not_found_this_category')]);

    if (!auth()->guard('client')->check()) {
      return redirect()->route('client.login');
    }
    // return Category::find($category_id)->_parent->id;
    $category = Category::with(['attributes', 'attributes.sub_attributes'])->whereIn('id', [$category_id ?? null, Category::find($category_id)->_parent->id ?? null])->orderBy('parent_id', 'desc')->get();
     //dd($category);
    // dd(count($category[0]->attributes->sub_attributes));
    if (!$category)
      return redirect()->back()->with(['error' => __('app/all.Not_found_this_category')]);
    // return $category;

    $category_id = 0;
    if (count($category) > 1) {
      $category_id =  $category->where('parent_id', '<>', null)->first()->id;
    } else {
      $category_id =  $category[0]->id;
    }

    $countries = Country::all();
    $categories = Category::all();
    return view('front.add_auction', compact(['countries', 'categories', 'category', 'category_id']));
  }

  function fetch(Request $request)
  {
    $select = $request->get('select');
    $value = $request->get('value');
    $dependent = $request->get('dependent');
    $items = [];

    $items = City::where('country_id', $value)->get();

    // $output = '<option disabled selected >من فضلك أختر قيمه</option>';
    // foreach ($items as $row) {
    //     $output .= '<option value="' . $row->id . '">' . $row->name . '</option>';
    // }


    $output = '';

    $output .= '<option value="">' . __("app/all.select_city") . '</option>';
    foreach ($items as $row) {
      $output .= '<option value="' . $row->id . '" >' . $row->name . '</option>';
    }
    // $output .= '</select>';


    echo $output;
  }


  // public function insert(Request $request)
  public function insert(AuctionRequest $request)
  {
    // try {
    $attributes_ids = '';
    $types_ids = '';
    $features = '';
    if ($request->features) {
      $attributes_ids = explode('-', $request->attributes_ids);
      $types_ids = explode('-', $request->types);
      $features = $request->features;
    }

    DB::beginTransaction();

    $cover_name = '';
    if ($request->hasFile('cover')) {
      # Upload New Image & Return its New Name
      $image_name = uploadInterventionImage($request->file('cover'), 'assets/images/auctions/');
      # Save New Name in DB
      $cover_name = $image_name;
    }
    $inserted_id = Auction::latest('id')->first();
    if($inserted_id==null){
        $inserted_id=1;
    }else{
        $inserted_id=$inserted_id->id+1;
    }
    //insert
    $auction = new Auction();
    $auction->client_id = auth('client')->user()->id;
    $auction->slug = $request->name . ' ' . $inserted_id;
    $auction->country_id = $request->country_id;
    $auction->city_id = $request->city_id;
    $auction->category_id = $request->category_id;
    $auction->name = $request->name;
    $auction->description = $request->description;
    $auction->min_price = $request->min_price;
    $auction->max_price   = $request->max_price;
    $auction->cover = $cover_name;
    $auction->video = $request->video ?? null;
    $auction->start_date = carbonDateTime($request->start_date);
    $auction->lat = $request->latitude ?? null;
    $auction->lng = $request->longitude ?? null;
    $auction->end_date = carbonDate($request->end_date);
    $auction->end_time = carbonTime($request->end_date);
    $auction->save();


    if ($request->images) {
      for ($i = 0; $i < count($request->images); $i++) {
        $img_name = '';
        if ($request->hasFile('images')) {
          # Upload New Image & Return its New Name
          $image_name = uploadInterventionImage($request->file('images')[$i], 'assets/images/auctions/');
          # Save New Name in DB
          $img_name = $image_name;
        }

        $auction_image = new AuctionImage();
        $auction_image->auction_id = $auction->id;
        $auction_image->image = $img_name;
        $auction_image->save();
      }
    }


    if ($request->features) {
      for ($i = 0; $i < count($features); $i++) {

        $new_auction_feature = new AuctionFeature();
        $new_auction_feature->auction_id = $auction->id;
        $new_auction_feature->attribute_id = $attributes_ids[$i];

        if ($types_ids[$i] == 0) {
          $new_auction_feature->sub_attribute_id = intval($features[$i]);
        } else {
          $new_auction_feature->value = $features[$i];
        }
        $new_auction_feature->save();
      }
    }

    DB::commit();

    return  redirect()->route('auction.recognition.page', ['slug' => $auction->slug]);
    // return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
    // } catch (\Exception $ex) {
    //   DB::rollback();
    //   return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    // }
  }


  public function auctionRecognitionPage($slug)
  {
    // return $slug;
    try {
      DB::beginTransaction();

      $auction = Auction::where('slug', $slug)->first();
      if (!$auction)
        return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);

      $recognitions = Recognition::all();
      // return $recognitions;

      DB::commit();

      return view('front.recognition')->with(['slug' => $slug, 'auction_id' => $auction->id, 'recognitions' => $recognitions ,'auction'=>$auction]);
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }


  public function auctionRecognition($id, Request $request)
  {
    // return $request;
    try {
      DB::beginTransaction();

      $auction = Auction::find($id);
      if (!$auction)
        return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);
      if ($auction->client_id != auth('client')->id())
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

      return redirect()->route('client.home')->with(['success_model' => __('admin/forms.added_successfully')]);
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }


  public function bid($id, Request $request)
  {
    // return $request->price;
    try {
      DB::beginTransaction();
      $auction = Auction::with(['bidings'])->find($id);
      if (!$auction)
        return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);
      if ($request->price < $auction->bidings()->max('value'))
        return redirect()->back()->with(['error' => __('app/all.Minimum_price_is') . ' ' . $auction->bidings()->max('value')]);

      //insert
      $latestbinding=Biding::where('auction_id',$auction->id)->latest('id')->first();
      if($latestbinding!=null){
        if($latestbinding->value==$request->price){
            return redirect()->back()->with(['error' => __('app/all.same_price')]);
        }
      }
      $bid = new Biding();
      $bid->auction_id = $id;
      $bid->client_id = auth('client')->id();
      $bid->value = $request->price;
      $bid->save();
      if($bid->value>=$auction->max_price){
        $carbon_now = Carbon::now();
        $bid->win = 1;
        $bid->save();
        $auction->status = 1;
        $auction->end_price = $bid->value;
        $auction->end_date = carbonDate($carbon_now);
        $auction->end_time = carbonTime($carbon_now);
        $auction->save();
      }
      NotificationService::sendSingleNotification(auth('client')->id(), 'client', 1, null, 'biding', $bid->id, $auction->client_id, 'client');
      DB::commit();
      return redirect()->back()->with(['success_model' => __('app/all.Bid_added_successfully')]);
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }


  public function acceptBid($id, Request $request)
  {
    // return $id;
    try {
      DB::beginTransaction();
      $carbon_now = Carbon::now();
      $biding = Biding::find($id);
      if (!$biding)
        return redirect()->back()->with(['error' => __('app/all.Not_found_this_biding')]);
      $auction = Auction::find($biding->auction_id);
      if (!$auction)
        return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);
      if ($auction->client_id != auth('client')->id())
        return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);
      $biding->win = 1;
      $biding->save();
      $auction->status = 1;
      $auction->end_price = $biding->value;
      $auction->end_date = carbonDate($carbon_now);
      $auction->end_time = carbonTime($carbon_now);
      $auction->save();

      NotificationService::sendSingleNotification(auth('client')->id(), 'client', 2, null, 'biding', $biding->id, $biding->client_id, 'client');

      DB::commit();

      return redirect()->back()->with(['success_model' => __('app/all.You_have_been_accepted_this_offer,_and_ended_this_auction')]);
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }

  public function deleteAuction($id)
  {
    // return $id;
    try {
      DB::beginTransaction();

      $auction = Auction::find($id);
      if (!$auction)
        return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);

      if ($auction->client_id != auth('client')->id())
        return redirect()->back()->with(['error' => __('app/all.Not_found_this_auction')]);

      $auction->delete();

      DB::commit();

      return redirect()->route('client.home')->with(['success_model' => __('app/all.You_have_been_deleted_the_auction_successfully')]);
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }
}
