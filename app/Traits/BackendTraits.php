<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;

Trait  backendTraits
{

    // save image
    function saveImage($photo,$folder){
        //save photo in folder
        $file_extension = $photo -> getClientOriginalExtension();
        $file_name = time().'.'.$file_extension;
        $path = $folder;
        $photo -> move($path,$file_name);
        return $file_name;
    }
    public function upploadImage($image,$folder)
    {
        $imageName = time() .'.'.$image->extension();
        $image->move(public_path($folder),$imageName); 
        return $imageName;
    }


    // save image by Image Intervention
    function imageInterve($image,$path){
        Image::make($image)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })
        ->save(public_path($path .$image->hashName()));
        $image = $image->hashName();
        return $image;
    }


    //distance between two coordinates in kilos
    function distance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return number_format(($miles * 1.609344),0,'.','');
    }
}
