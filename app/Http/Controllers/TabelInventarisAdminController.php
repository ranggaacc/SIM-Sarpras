<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Inventaris;
use App\Pengadaan;
use App\UnitKerja;
use App\User;
use Auth;
class TabelInventarisAdminController extends Controller
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

    public function index(){

    }    

    public function show($id)
    {
        $i1=1;
        $unit=UnitKerja::select('id','nama')->where('nama',$id)->first();
        $inventariss= Inventaris::where('id_unit',$unit->id)
        ->join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->select('inventaris.id','kode_barang','inventaris.nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi','gambar')
        ->get();
        // dd($inventariss);
        return view('admin.tables',compact('inventariss','i1','id','unit'));
    }
}

