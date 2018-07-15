<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Inventaris;
use App\UnitKerja;
use App\Pengadaan;
use App\User;
use Auth;
class TabelInventarisController extends Controller
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
        $id_unit= Auth::user()->pegawai->id_unit;
        $inventaris= Inventaris::where(['id_unit'=>$id_unit])->get();
    	return view('middle.tables',compact('inventaris'));
    }    

    public function show($id)
    {
        $i1=1;
        $inventariss= Inventaris::where(['unit'=>$id])->get();
        return view('middle.tables',['inventariss' => $inventariss,'i1'=>$i1]);
    }
}

