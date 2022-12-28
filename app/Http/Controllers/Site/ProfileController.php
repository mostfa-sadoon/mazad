<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientEditPasswordRequest;
use App\Http\Requests\ClientProfileRequest;
use App\Models\Auction;
use App\Models\Biding;
use App\Models\Client;
use App\Models\Country;
use App\Models\Favourite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

// __('app/all.')

  public function getProfile()
  {
    try {
      $client = auth('client')->user();
      $countries = Country::all();

      // return $client;
      return view('front.profile', compact(['client', 'countries']));
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }

  public function updateProfile(ClientProfileRequest $request)
  {
    $request['phone'] = explode($request->country_code, $request->phone)[1];
    // return $request;
    try {
      $client_id = auth('client')->id();

      $client = Client::where(['id' => $client_id])->first();
      if (!$client)
        return redirect()->back()->with(['error' => __('app/all.Un_Authenticated')]);

      $photo_name = $client->getAttributes()['photo'];

      if ($request->hasFile('photo')) {
        # Delete Old Image
        if ($photo_name != 'not.png') {
          deleteFile($photo_name, 'assets/images/clients/');
        }
        # Upload New Image & Return its New Name
        $image_name = uploadImage($request->file('photo'), 'assets/images/clients/');
        # Save New Name in DB
        $photo_name = $image_name;
      }

      $client->f_name = $request->f_name;
      $client->l_name = $request->l_name;
      $client->country_code = $request->country_code;
      $client->phone = $request->phone;
      $client->country_id = $request->country_id;
      $client->email = $request->email;
      $client->photo = $photo_name;
      $client->save();

      return redirect()->back()->with(['success_model' => __('app/all.You_have_been_updated_your_profile')]);
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }


  public function editPassword()
  {
    try {
      return view('front.edit_password');
    } catch (\Exception $ex) {
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }

  public function updatePassword(ClientEditPasswordRequest $request)
  {
    // return $request;
    try {
      $client = auth('client')->user();

      if (Hash::check($request->old_password, $client->password)) {

        Client::find($client->id)->update([
          'password' => bcrypt($request->password),
        ]);

        return redirect()->back()->with('success_model', __('app/all.Password_has_been_changed'));
      } else {
        return redirect()->back()->with('error', __('app/all.The_password_is_incorrect'));
      }
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


  public function getMyAuctions()
  {
    try {
      $data['auctions'] = Auction::with(['city', 'city.country'])->where('client_id', auth('client')->id())->paginate(PAGINATION_COUNT);
      // return $data['auctions'];
      return view('front.my_auctions')->with($data);
    } catch (\Exception $ex) {
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }

  public function getMyBids()
  {
    try {
      $client_id = auth('client')->id();

      $data['bids'] = Biding::select('auction_id')
        ->where('client_id', $client_id)
        ->groupBy('auction_id')
        ->get()->pluck('auction_id')->toArray();

      $data['auctions'] = Auction::with(['city', 'city.country'])->whereIn('id', $data['bids'])->paginate(PAGINATION_COUNT);
      // return $data['bids'];

      return view('front.my_bids')->with($data);
    } catch (\Exception $ex) {
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }


  public function deleteAccount()
  {
    try {
      
      $client = Client::find(auth('client')->id());
      $client->delete();
        return redirect()->route('client.home')->with('success_model', __('app/all.Account_has_been_deleted'));

    } catch (\Exception $ex) {
      return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }
  }
}
