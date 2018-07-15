<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use ConsoleTVs\Charts\Facades\Charts;
use App\Inventaris;
use App\UnitKerja;
use App\KodeBarang;
use App\Pengadaan;
use Auth;

class ExecutiveController extends Controller
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
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('roles:3');

    } 
    public function index(){


    }
    public function show($id){
        $nama_unit=$id;
        /*ALL INVENTARIS*/
        $unit=UnitKerja::where('nama',$id)->first();
        $id=$unit->id;
        $inventaris= Inventaris::where(['id_unit'=>$id])->count();
        $inventarisgetall= Inventaris::where(['id_unit'=>$id])->get();
        $jumlahinventarisB=0;
        $jumlahinventarisRR=0;
        $jumlahinventarisRB=0;
        $i=0;
        /*count barang BARU*/
        for($i=0;$i<$inventaris;$i++){
          $jumlahinventarisB+=$inventarisgetall[$i]->B;
        }
        /*count barang RUSAK RINGAN*/
        for($i=0;$i<$inventaris;$i++){
          $jumlahinventarisRR+=$inventarisgetall[$i]->RR;
        }
        /*count barang RUSAK BERAT*/
        for($i=0;$i<$inventaris;$i++){
          $jumlahinventarisRB+=$inventarisgetall[$i]->RB;
        }

        if($inventaris>0){

        $inventarisgetall= Inventaris::select('B','RR','RB')->where(['id_unit'=>$id])
        ->join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->get();
        $get_tahun = Inventaris::where(['id_unit'=>$id])
                ->select('tahun_barang')
                ->groupBy('tahun_barang')
                ->get();
        $count_get_tahun=count($get_tahun);
        $counter=0;
        for ($i=0; $i < $count_get_tahun; $i++) { 
          for ($j=0; $j < 3; $j++) { 
            $kondisiinventaris[$i][$j]=0;
          }
          $jumlah_inventaris[$i]=0;
        }
        foreach($get_tahun as $tahu) { 
          $baru = Inventaris::where(['id_unit'=>$id])->where('tahun_barang', $tahu->tahun_barang)->get();
          foreach ($baru as $bar) {
            $kondisiinventaris[$counter][0]+=$bar->B; //$kondisi[][0]=B; $kondisi[][1]=RR; $kondisi[][2]=RB
            $kondisiinventaris[$counter][1]+=$bar->RR;
            $kondisiinventaris[$counter][2]+=$bar->RB;

            $nama_inventaris[$counter]=$bar->tahun_barang; //Nama barang
            $jumlah_inventaris[$counter]+=$bar->jumlah_barang; //Jumlah barang
          }
          $counter++;
          $baru=0;
        }
        $chartinventaris =Charts::create('bar', 'highcharts')
              ->title('Inventaris Berdasarkan Tahun')
              ->colors(['#ffb3ba','#ffdfba','#ffffba','#baffc9',' #bae1ff','#f5f5f5','#abc0c1','#c2c502','#7f8c8d','#e74c3c','#c0392b','#bdc3c7','#2980b9','#8e44ad','#9b59b6','#3498db'])
              ->kondisi($kondisiinventaris) 
              ->labels($nama_inventaris)
              ->values($jumlah_inventaris)
              ->xAxisTitle('Tahun')
              ->yAxisTitle('values')
              ->dimensions(600,600)
              ->responsive(true);


        $nama_kondisi=['B','RR','RB'];
        $values_kondisi=[$jumlahinventarisB,$jumlahinventarisRR,$jumlahinventarisRB];
        $chartinventaris2 =Charts::create('bar', 'highcharts')
              ->title('Inventaris Berdasarkan Kondisi')
              ->colors(['#baffc9','#ffdfba','#ffb3ba'])           
              ->labels($nama_kondisi)
              ->values($values_kondisi)
              ->xAxisTitle('Kondisi')
              ->yAxisTitle('values')
              ->dimensions(600,600)
              ->responsive(true);

        }

        else {
              $chartinventaris=Charts::create('pie', 'highcharts')
              ->title('Inventaris'.$id)
              ->colors(['#ffb3ba','#ffdfba','#ffffba','#baffc9',' #bae1ff','#f5f5f5','#abc0c1','#c2c502','#7f8c8d','#e74c3c','#c0392b','#bdc3c7','#2980b9','#8e44ad','#9b59b6','#3498db'])
              ->kondisi(0) 
              ->labels(0)
              ->values(0)
              ->dimensions(1000,600)
              ->responsive(false);

              $chartinventaris2=Charts::create('pie', 'highcharts')
              ->title('Inventaris'.$id)
              ->colors(['#ffb3ba','#ffdfba','#ffffba','#baffc9',' #bae1ff','#f5f5f5','#abc0c1','#c2c502','#7f8c8d','#e74c3c','#c0392b','#bdc3c7','#2980b9','#8e44ad','#9b59b6','#3498db'])
              ->kondisi(0) 
              ->labels(0)
              ->values(0)
              ->dimensions(1000,600)
              ->responsive(false);
            }
    	return view('executive.executive',compact('inventaris','jumlahinventarisB','jumlahinventarisRR','jumlahinventarisRB','inventarisgetall','y','y2','y3','y4','inventarispanel2','inventarispanel3','inventarispanel4','unit','chartinventaris' ,'chartinventaris2', 'id','nama_unit','inventaris'));
    }
    public function jenis($id){
        /*panel jenis barang*/
        $unit= UnitKerja::where(['nama'=>$id])->first();
       
        $inventarisgetall= Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->where('id_unit',$unit->id)->get();
        return view('executive.show',compact('inventarisgetall','unit'));
    }
    public function panel2($id){
        $unit= UnitKerja::where(['nama'=>$id])->first();

        $inventarispanel2=Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->where('id_unit',$unit->id)
        ->where('B','>','0')
        ->get();

        return view('executive.panel2',['inventarispanel2'=>$inventarispanel2]);
    }
    public function panel3($id){
        $unit= UnitKerja::where(['nama'=>$id])->first();
        $inventarispanel3=Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->where('id_unit',$unit->id)
        ->where('RR','>','0')
        ->get();
      return view('executive.panel3',['inventarispanel3'=>$inventarispanel3]);
    }
    public function panel4($id){
        $unit= UnitKerja::where(['nama'=>$id])->first();
        $inventarispanel4= Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->where('id_unit',$unit->id)
        ->where('RB','>','0')
        ->get();
      return view('executive.panel4',['inventarispanel4'=>$inventarispanel4]);
    }
}
