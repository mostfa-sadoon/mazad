<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;
use DB;
class LogoController extends Controller
{
    //
    public function edit(){
       $logo=Logo::find(1);
       return view('dashboard.logo.edit',compact('logo'));
    }
    public function update(Request $request){
         try{
            DB::beginTransaction();
            $logo= Logo::find(1);
            if ($request->hasFile('cover')) {
                # Upload New Image & Return its New Name
                $image_name = uploadImage($request->file('cover'), 'assets/images/logo/');
                # Save New Name in DB
                $cover_name = $image_name;
                $logo->update([
                    'logo'=>$cover_name,
                ]);
            }
            DB::commit();
            return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
         }catch(\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
