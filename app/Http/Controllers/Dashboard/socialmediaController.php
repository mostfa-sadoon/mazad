<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Socialmedia;
use DB;
class socialmediaController extends Controller
{
    //
    public function index(){
        $Socialmedias=Socialmedia::get();
        return view('dashboard.socialmedia.index',compact('Socialmedias'));
    }
    public function edit($id){
        $Socialmedia=Socialmedia::find($id);
        return view('dashboard.socialmedia.edit',compact('Socialmedia'));
    }
    public function update(Request $request){
        try {
            DB::beginTransaction();
             $id=$request->id;
             $socialmedia=Socialmedia::find($id);
             $socialmedia->update([
               'url'=>$request->url,
               'icon'=>$request->icon,
             ]);
            DB::commit();
            return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
    public function destroy($id){
        $socialmedia=Socialmedia::find($id)->delete();
        return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
    }
}
