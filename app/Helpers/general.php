<?php

// use Illuminate\Support\Facades\DB;

use App\Models\Auction;
use App\Models\Category;
use App\Models\Country;
use App\Models\SentNotification;
use App\Models\Setting;
use App\Models\Logo;
use App\Models\Socialmedia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Intervention\Image\ImageManagerStatic as Image;

define('PAGINATION_COUNT', 20);
define('db_limit', 20);
define('location', 50);


function getFolder()
{
	return app()->getLocale() == 'ar' ? 'css-rtl' : 'css';
}

function sortArray($arr = [])
{
	for ($i = 0; $i < count($arr); $i++) {
		$val = $arr[$i];
		$j = $i - 1;
		while ($j >= 0 && $arr[$j] > $val) {
			$arr[$j + 1] = $arr[$j];
			$j--;
		}
		$arr[$j + 1] = $val;
	}
	return $arr;
}


function getActiveName($value)
{
	$methods = [
		'ar' => [
			0 => 'غير مفعل',
			1 => 'مفعل',
		],
		'en' => [
			0 => 'Not Active',
			1 => 'Active',
		],
		'fr' => [
			0 => 'Not Active fr',
			1 => 'Active fr',
		]
	];

	if (app()->getLocale() == 'ar') {
		return $methods['ar'][$value];
	} else {
		return $methods['en'][$value];
	}
}


function getCategories()
{
	$categories = Category::parent()->select('id', 'image')->get();
	return $categories;
}

function getlogo(){
    $logo=Logo::find(1);
    return $logo->logo;
}

function getCountries()
{
	$countries = Country::select('id', 'image')->orderBy('id', 'desc')->get();
	return $countries;
}
function firstCountry()
{
	$country = Country::select('id', 'image')->first();
	return $country;
}
function findCountry($id)
{
	$country = Country::select('id', 'image')->find($id);
    if($country==null){
        $country = Country::select('id', 'image')->first();
    }
	return $country;
}


function socialmedias()
{
    $Socialmedias=Socialmedia::get();
     return $Socialmedias;
}



function auctionStatus($i)
{
	$methods = [
		'ar' => [
			1 => 'تم بيعه',
			2 => 'مُغلق',
			3 => 'متاح',
			4 => 'قادمه',
		],
		'en' => [
			1 => 'Sold',
			2 => 'Closed',
			3 => 'Open',
			4 => 'Coming',
        ],
        'fr' => [
			1 => 'Vendue',
			2 => 'Fermée',
			3 => 'Ouvrir',
			4 => 'À venir',
		]
	];

	if (app()->getLocale() == 'ar') {
		return [$i, $methods['ar'][$i]];
	} else {
		return [$i, $methods['en'][$i]];
	}
}

function getAuctionStatus(Auction $auction)
{
	$now = Carbon::now()->toDateTimeString();
	$auction_datetime = $auction->end_date . ' ' . $auction->end_time;

	$status = auctionStatus(3);

	if ($now > $auction_datetime) {
		$status = auctionStatus(2);
	}
	if (in_array($auction->status, [1, 2])) {
		$status = auctionStatus($auction->status);
	}

	if ($now < $auction->start_date) {
		$status = auctionStatus(4);
	}

	// if ($auction->status == 2) {
	// 	$status = 'Closed';
	// }
	// if ($auction->status == 1) {
	// 	$status = 'Sold';
	// }
	return $status;
}


function carbonTime($datetime)
{
	return Carbon::parse($datetime)->toTimeString();
}
function carbonDate($datetime)
{
	return Carbon::parse($datetime)->toDateString();
}
function carbonDateTime($datetime)
{
	return Carbon::parse($datetime)->toDateTimeString();
}


function checkExist($item)
{
	if ($item && $item != null) {
		return $item;
	} else {
		return null;
	}
}




function uploadImage($photo_name, $folder)
{
	$image = $photo_name;
	$image_name = time() . '' . $image->getClientOriginalName();
	$destinationPath = public_path($folder);
	$image->move($destinationPath, $image_name);
	return $image_name;
}

function uploadInterventionImage($photo_name, $folder)
{
	$image = $photo_name;
	$image_name = time() . '' . $image->getClientOriginalName();

	$intervention_image = Image::make($image->getRealPath());
	$watermark = Image::make(public_path("watermark.png"));
	$watermark->resize(100, 100);
	$intervention_image->insert($watermark, 'bottom right', 10, 10);

	$destinationPath = public_path($folder);
	$intervention_image->save($destinationPath . $image_name, 60);
	return $image_name;
}

function deleteFile($photo_name, $folder)
{
	$image_name = $photo_name;
	$image_path = public_path($folder) . $image_name;
	if (file_exists($image_path)) {
		@unlink($image_path);
	}
}

function is_active_req($request)
{
	if (!$request->has('is_active'))
		$request->request->add(['is_active' => 0]);
	else
		$request->request->add(['is_active' => 1]);
}

function getNotificationMessage($message_id)
{
	$messages = [
		'ar' => [
			# Messages From Client
			1 => 'مذايده جديده بقيمه ',
			2 => 'تهانينا ،ربحت المزاد بقيمه ',
		],
		'en' => [
			# Messages From Client
			1 => 'New bidding of ',
			2 => 'Congratulations, you\'ve won the auction with a value of ',
		],
		'fr' => [
			# Messages From Client
			1 => 'Nouvelle enchère de ',
			2 => 'Félicitations, vous avez remporté l\'enchère d\'une valeur de ',
		]
	];

	if (app()->getLocale() == 'ar') {
		return $messages['ar'][$message_id];
	} elseif (app()->getLocale() == 'en') {
		return $messages['en'][$message_id];
	} else {
		return $messages['fr'][$message_id];
	}
}

function getNotifications($receiver_model, $receiver_id = null)
{
	$notys = [];
	if ($receiver_model == 'admin') {
		$notys = SentNotification::where(['receiver_model' => 'admin'])->orderBy('id', 'desc')->paginate(PAGINATION_COUNT);
	} elseif ($receiver_model == 'client') {
		$notys = SentNotification::where(['receiver_model' => $receiver_model, 'receiver_id' => $receiver_id])->orderBy('id', 'desc')->paginate(PAGINATION_COUNT);
	}
	return $notys;
}



function getSettings($what)
{
	$setting = Setting::where('what', $what)->first();
	return $setting;
}
