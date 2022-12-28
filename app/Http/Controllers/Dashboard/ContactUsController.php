<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use DB;
class ContactUsController extends Controller
{
    //
    public function edit(){
        $ContactUs=ContactUs::find(1);
        return view('dashboard.ContactUs.edit',compact('ContactUs'));
     }
     public function update(Request $request){
          try{
             DB::beginTransaction();
             $ContactUs=ContactUs::find(1);
              $request->validate([
                'phone'=>'required'
              ]);
             $ContactUs->update([
                'number'=>$request->phone,
            ]);
             DB::commit();
             return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
          }catch(\Exception $ex) {
             DB::rollback();
             return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
         }
     }
}
