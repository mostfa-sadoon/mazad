<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuctionRequest;
use App\Models\Auction;
use App\Models\AuctionImage;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{


  // public function auctionsByCategory($id)
  // {
  //   $category = Category::child()->where(['id'=> $id])->first();
    
  //   if (!$category)
  //   return redirect()->back()->with(['error' => 'Not found this category']);

  //   return view('front.add_auction', compact(['countries', 'categories']));
  // }


  public function getCategories()
  {
    $categories = Category::parent()->select('id' , 'image')
      ->with(['childrens' => function ($q) {
        $q->select('id', 'parent_id' , 'image');
        // $q->with(['childrens' => function ($qq) {
        //   $qq->select('id', 'parent_id');
        // }]);
      }])->get();

    // return $categories;
    return view('front.add_auction_first_cat', compact(['categories']));
  }
}
