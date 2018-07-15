<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Pegawai;
use App\Pengadaan;
use App\User;
use App\UnitKerja;
use App\Peminjam;
use Auth;
use Hashids;
class EditProfilController extends Controller
{
    // public function __construct() {
    //   view()->composer('*', function ($view) {
    //       $id_unit= Auth::user()->pegawai->id_unit;
    //       $unit= UnitKerja::where(['id'=>$id_unit])->first();
    //       $notifs=Pengadaan::where('approvement','0')->get();
    //       $notif2s=Pengadaan::where('unit',$unit->nama)
    //       ->where('approvement','>','0')
    //       ->get();
    //       $count_notif=count($notifs);
    //       $users_notifs=Auth::user()->user_si;
    //       $view->with(['notifs'=> $notifs,'users_notifs'=>$users_notifs,'count_notif'=>$count_notif,'notif2s'=>$notif2s]);
    //   });
    // }

    public function editprofil($id)
    {
        
        $id=Hashids::decode($id);
        
        $user = User::findOrFail($id[0]);
        return view('profil.edit', compact('user'));
    }
    public function editprofilpeminjam($id)
    {
        
        $id=Hashids::decode($id);
        
        $user = User::findOrFail($id[0]);
        return view('profil.editpeminjam', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function postprofil(Request $request, $id)
    {
        
            $this->validate($request, [
            // 'email' => 'required|email|max:255',
            // 'username' => 'required|max:255',
            'password' => 'required|min:6|confirmed'
            // 'image' => 'mimes:jpeg,bmp,jpg,png|max:5000'
        ]); 

        $user = User::findOrFail($id);
        // $user->username=$request->username;
        // $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();


        // $pegawai = Pegawai::findOrFail($request->id_pegawai);
        // $pegawai->email=$request->email;
        // if(count($request->image)>0){
        //     $file = $request->file('image');
        //     $fileName = $file->getClientOriginalName();
        //     $request->file('image')->move("imageProfil/",$fileName);
        //     $pegawai->gambar = $fileName;
        // }        
        // $pegawai->save();
        flash('Edit password berhasil')->important()->success();
        return redirect()->back();
    }
    public function postprofilpeminjam(Request $request, $id)
    {
            $this->validate($request, [
            'email' => 'required|email|max:255',
            'username' => 'required|max:255',
            'nama' => 'required|max:255',
            'jenis_kelamin' => 'required|max:255',
            'nomor_hp' => 'required|max:255',
            'telepon' => 'required|max:255',
            'username' => 'required|max:255',
            // 'password' => 'required|min:6|confirmed',
            'image' => 'mimes:jpeg,bmp,jpg,png|max:5000'
        ]); 

        $user = User::findOrFail($id);
        $user->username=$request->username;
        $user->email=$request->email;
        // $user->password=bcrypt($request->password);
        $user->save();


        $peminjam = Peminjam::where('user_id',$id)->first();
        $peminjam->nama=$request->nama;
        $peminjam->jenis_kelamin=$request->jenis_kelamin;
        $peminjam->nomor_hp=$request->nomor_hp;
        $peminjam->telepon=$request->telepon;
        if(count($request->image)>0){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $request->file('image')->move("imageProfil/",$fileName);
            $peminjam->gambar = $fileName;
        }        
        $peminjam->save();
        flash('Edit profil berhasil')->important()->success();
        return redirect()->back();
    }
}

