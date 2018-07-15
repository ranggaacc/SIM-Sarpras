<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use App\Inventaris;
use App\UnitKerja;
use App\KodeBarang;
use App\Pengadaan;
use App\ItemPengadaan;
use App\Pegawai;
use Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct() {
    //   if(Auth::user()->id_pegawai!=null){
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
    // }

    public function index()
    {
      $users=Auth::user()->user_si;
      $true=0;
      // dd($users);
      foreach ( $users as $key) {        
        if($key->id_si==1){
          $true+=1;
          break;
        }
      }
      if($true==0){
        Auth::logout();
        flash('Akun anda belum terdaftar sebagai pengguna sistem ini')->important()->error();
        return view('auth.login');
      }
      if(Auth::user()->id_pegawai!=0){
        $id_unit= Auth::user()->pegawai->id_unit;
        $unit= UnitKerja::where(['id'=>$id_unit])->first();
        // dd($unit);

        /*PANEL DASHBOARD*/
        $y=1;
        $y2=1;
        $y3=1;
        $y4=1;
        $inventarispanel2= Inventaris::where(['id_unit'=>$id_unit])->orderBy('tahun_barang','desc')->where(function($query) {
         $query->select('nama_barang','B','tahun_barang')->where('B','>','0');
        })->get();
        $inventarispanel3= Inventaris::where(['id_unit'=>$id_unit])->orderBy('tahun_barang','desc')->where(function($query) {
         $query->select('nama_barang','RR','tahun_barang')->where('RR','>','0');
        })->get();
        $inventarispanel4= Inventaris::where(['id_unit'=>$id_unit])->orderBy('tahun_barang','desc')->where(function($query) {
         $query->select('nama_barang','RB','tahun_barang')->where('RB','>','0');
        })->get();

        /*ALL INVENTARIS*/
        
        $inventaris= Inventaris::where(['id_unit'=>$id_unit])->count();
        $inventarisgetall= Inventaris::where(['id_unit'=>$id_unit])->get();
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
        
        /*percobaan*/
        /*edit plugin search bar.blade highcharts + builder consoleTVs chart*/
        if($inventaris>0){
            $inventarisgetall= Inventaris::where(['id_unit'=>$id_unit])->get();
            $get_tahun = Inventaris::where(['id_unit'=>$id_unit])
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
              $baru = Inventaris::where(['id_unit'=>$id_unit])->where('tahun_barang', $tahu->tahun_barang)->get();
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
                    ->title('Inventaris '.$unit->nama.' Berdasarkan Tahun')
                    ->colors(['#ffb3ba','#ffdfba','#ffffba','#baffc9',' #bae1ff','#f5f5f5','#abc0c1','#c2c502','#7f8c8d','#e74c3c','#c0392b','#bdc3c7','#2980b9','#8e44ad','#9b59b6','#3498db'])
                    ->kondisi($kondisiinventaris) 
                    ->labels($nama_inventaris)
                    ->xAxisTitle('Tahun')
                    ->yAxisTitle('values')
                    ->values($jumlah_inventaris)
                    ->dimensions(1000,600)
                    ->responsive(false);

        }
        else $chartinventaris=Charts::create('bar', 'highcharts')
              ->title('Inventaris')
              ->colors(['#ffb3ba','#ffdfba','#ffffba','#baffc9',' #bae1ff','#f5f5f5','#abc0c1','#c2c502','#7f8c8d','#e74c3c','#c0392b','#bdc3c7','#2980b9','#8e44ad','#9b59b6','#3498db'])
              ->kondisi(0) 
              ->labels(0)
              ->xAxisTitle('Tahun')
              ->yAxisTitle('values')
              ->values(0)
              ->dimensions(1000,600)
              ->responsive(false);

        /*ALL EXECUTIVE*/
        $j =0;
        $j1=0;
        $j2=0;
        $j3=0;
        $j4=0;
        $x1=0;
        $x2=0;
        $x3=0;
        $jumlahuih=0;
        $jumlahlpsb=0;
        $jumlahuppw=0;
        $jumlahukbb=0;
        $jumlahukhp=0;
        $jumlahB=0;
        $jumlahRR=0;
        $jumlahRB=0;
        /*COUNT EXE->UIH id=1*/
        $uih=Inventaris::where('id_unit','=','1')->count();
        $uihgetall= Inventaris::where('id_unit','=','1')->get();
        $jumlahuihB=0;
        $jumlahuihRR=0;
        $jumlahuihRB=0;
        $i=0;
        /*count barang BARU*/
        for($i=0;$i<$uih;$i++){
          $jumlahuihB+=$uihgetall[$i]->B;
        }
        /*count barang RUSAK RINGAN*/
        for($i=0;$i<$uih;$i++){
          $jumlahuihRR+=$uihgetall[$i]->RR;
        }
        /*count barang RUSAK BERAT*/
        for($i=0;$i<$uih;$i++){
          $jumlahuihRB+=$uihgetall[$i]->RB;
        }
        

        





        /*COUNT EXE->ukbb/ukbb id=2*/
        $ukbb=Inventaris::where('id_unit','=','2')->count();
        $ukbbgetall= Inventaris::where('id_unit','=','2')->get();
        $jumlahukbb=0;
        $jumlahukbbB=0;
        $jumlahukbbRR=0;
        $jumlahukbbRB=0;
        $i1=0;
        /*count barang BARU*/
        for($i1=0;$i1<$ukbb;$i1++){
          $jumlahukbbB+=$ukbbgetall[$i1]->B;
        }
        /*count barang RUSAK RINGAN*/
        for($i1=0;$i1<$ukbb;$i1++){
          $jumlahukbbRR+=$ukbbgetall[$i1]->RR;
        }
        /*count barang RUSAK BERAT*/
        for($i1=0;$i1<$ukbb;$i1++){
          $jumlahukbbRB+=$ukbbgetall[$i1]->RB;
        }
        for($j1=0;$j1<$ukbb;$j1++){
          $jumlahukbb+=$ukbbgetall[$j1]->jumlah_barang;
        }





        /*COUNT EXE->ukhp/ukhp id=3*/
        $ukhp=Inventaris::where('id_unit','=','3')->count();
        $ukhpgetall= Inventaris::where('id_unit','=','3')->get();
        $jumlahukhp=0;
        $jumlahukhpB=0;
        $jumlahukhpRR=0;
        $jumlahukhpRB=0;
        $i2=0;
        /*count barang BARU*/
        for($i2=0;$i2<$ukhp;$i2++){
          $jumlahukhpB+=$ukhpgetall[$i2]->B;
        }
        /*count barang RUSAK RINGAN*/
        for($i2=0;$i2<$ukhp;$i2++){
          $jumlahukhpRR+=$ukhpgetall[$i2]->RR;
        }
        /*count barang RUSAK BERAT*/
        for($i2=0;$i2<$ukhp;$i2++){
          $jumlahukhpRB+=$ukhpgetall[$i2]->RB;
        }              
        for($j2=0;$j2<$ukhp;$j2++){
          $jumlahukhp+=$ukhpgetall[$j2]->jumlah_barang;
        }

        $pengadaans = ItemPengadaan::all();
        $formpengadaans = Pengadaan::where('approvement','0')
        ->orderBy('created_at', 'desc')->get();

        /*COUNT EXE->workshop/uppw id=4*/ 
        $uppw=Inventaris::where('id_unit','=','4')->count();
        $uppwgetall= Inventaris::where('id_unit','=','4')->get();
        $jumlahuppw=0;
        $jumlahuppwB=0;
        $jumlahuppwRR=0;
        $jumlahuppwRB=0;
        $i3=0;
        /*count barang BARU*/
        for($i3=0;$i3<$uppw;$i3++){
          $jumlahuppwB+=$uppwgetall[$i3]->B;
        }
        /*count barang RUSAK RINGAN*/
        for($i3=0;$i3<$uppw;$i3++){
          $jumlahuppwRR+=$uppwgetall[$i3]->RR;
        }
        /*count barang RUSAK BERAT*/
        for($i3=0;$i3<$uppw;$i3++){
          $jumlahuppwRB+=$uppwgetall[$i3]->RB;
        }  
        for($j3=0;$j3<$uppw;$j3++){
          $jumlahuppw+=$uppwgetall[$j3]->jumlah_barang;
        }



        /*COUNT EXE->workshop/lpsb id=5*/
        $lpsb=Inventaris::where('id_unit','=','5')->count();
        $lpsbgetall= Inventaris::where('id_unit','=','5')->get();
        $jumlahlpsb=0;
        $jumlahlpsbB=0;
        $jumlahlpsbRR=0;
        $jumlahlpsbRB=0;
        $i4=0;
        /*count barang BARU*/
        for($i4=0;$i4<$lpsb;$i4++){
          $jumlahlpsbB+=$lpsbgetall[$i4]->B;
        }
        /*count barang RUSAK RINGAN*/
        for($i4=0;$i4<$lpsb;$i4++){
          $jumlahlpsbRR+=$lpsbgetall[$i4]->RR;
        }
        /*count barang RUSAK BERAT*/
        for($i4=0;$i4<$lpsb;$i4++){
          $jumlahlpsbRB+=$lpsbgetall[$i4]->RB;
        }        
        for($j4=0;$j4<$lpsb;$j4++){
          $jumlahlpsb+=$lpsbgetall[$j4]->jumlah_barang;
        }




        /*COUNT SEKRET->SEKRETARIAT/lpsb id=10*/
        $sekret=Inventaris::where('id_unit','=','10')->count();
        $sekretgetall= Inventaris::where('id_unit','=','10')->get();
        $jumlahsekret=0;
        $jumlahsekretB=0;
        $jumlahsekretRR=0;
        $jumlahsekretRB=0;
        $i5=0;
        /*count barang BARU*/
        for($i5=0;$i5<$sekret;$i5++){
          $jumlahsekretB+=$sekretgetall[$i5]->B;
        }
        /*count barang RUSAK RINGAN*/
        for($i5=0;$i5<$sekret;$i5++){
          $jumlahsekretRR+=$sekretgetall[$i5]->RR;
        }
        /*count barang RUSAK BERAT*/
        for($i5=0;$i5<$sekret;$i5++){
          $jumlahsekretRB+=$sekretgetall[$i5]->RB;
        }        
        for($j5=0;$j5<$sekret;$j5++){
          $jumlahsekret+=$sekretgetall[$j5]->jumlah_barang;
        }


        /*Count Kondisi B*/
        $jumlahB=$jumlahuihB+$jumlahukbbB+$jumlahukhpB+$jumlahuppwB+$jumlahlpsbB+$jumlahsekretB;
        /*Count Kondisi RR*/
        $jumlahRR=$jumlahuihRR+$jumlahukbbRR+$jumlahukhpRR+$jumlahuppwRR+$jumlahlpsbRR+$jumlahsekretRR;
        /*Count Kondisi RB*/
        $jumlahRB=$jumlahuihRB+$jumlahukbbRB+$jumlahukhpRB+$jumlahuppwRB+$jumlahlpsbRB+$jumlahsekretRB;

        $nama_unit=['UKHP','LPSB','UKBB','UIH','UPPW','SEKRETARIAT'];
        $values_unit=[$ukhp,$lpsb,$ukbb,$uih,$uppw,$sekret];
        $kondisi_unit=['B','RR','RB'];
        $values_kondisi=[$jumlahB,$jumlahRR,$jumlahRB];

        if($values_unit>0){
        $chartexecutive =Charts::create('bar', 'highcharts')
              ->title('Jumlah Barang Setiap Unit')
              ->colors(['#ffb3ba','#ffdfba','#ffffba','#baffc9',' #bae1ff','#f5f5f5','#abc0c1','#c2c502','#7f8c8d','#e74c3c','#c0392b','#bdc3c7','#2980b9','#8e44ad','#9b59b6','#3498db']) 
              ->labels($nama_unit)//
              ->xAxisTitle('UNIT')
              ->yAxisTitle('values')
              ->values($values_unit)
              ->dimensions(1000,600)
              ->responsive(true);

        $chartexecutive2 =Charts::create('bar', 'highcharts')
              ->title('Kondisi Barang')
              ->colors(['#baffc9','#ffdfba','#ffb3ba']) 
              ->labels($kondisi_unit)//$kondisi_unit
              ->xAxisTitle('Kondisi')
              ->yAxisTitle('values')
              ->values($values_kondisi)
              ->dimensions(1000,600)
              ->responsive(true);
        }
        else{
        $chartexecutive =Charts::create('bar', 'highcharts')
              ->title('Jumlah Barang Setiap Unit')
              ->colors(['#ffb3ba','#ffdfba','#ffffba','#baffc9',' #bae1ff','#f5f5f5','#abc0c1','#c2c502','#7f8c8d','#e74c3c','#c0392b','#bdc3c7','#2980b9','#8e44ad','#9b59b6','#3498db']) 
              ->labels(0)
              ->values(0)
              ->dimensions(1000,600)
              ->responsive(true);

        $chartexecutive2 =Charts::create('bar', 'highcharts')
              ->title('Kondisi Barang')
              ->colors(['#baffc9','#ffdfba','#ffb3ba']) 
              ->labels(0)
              ->values(0)
              ->dimensions(1000,600)
              ->responsive(true);
          }

          
        if(Auth::user()->user_si[0]->id_role=='3'){
            return view('executive.dashboard',compact('chartexecutive','chartexecutive2'));
        }
        elseif(Auth::user()->user_si[0]->id_role=='1'){
            return view('admin.dashboard',compact('chartexecutive','chartexecutive2','formpengadaans'));
        }
        elseif(Auth::user()->user_si[0]->id_role=='4'){
            return redirect()->route('peminjaman.index');
        }
        else{
            return view('middle.dashboard',compact('inventaris','chartinventaris','jumlahinventarisB','jumlahinventarisRR','jumlahinventarisRB','inventarisgetall','y','y2','y3','y4','inventarispanel2','inventarispanel3','inventarispanel4','unit','formpengadaans'));
        }
      }
      else {
        return redirect()->route('peminjaman.index');
      }
    }
    public function show($id){
        /*panel jenis barang*/
        $id_unit= Auth::user()->pegawai->id_unit;
        $unit= UnitKerja::where(['id'=>$id_unit])->first();
        $inventarisgetall= Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->where(['id_unit'=>$id])->get();
        return view('middle.show',compact('inventarisgetall','unit'));
    }
    public function panel($id){

        $id_unit= Auth::user()->pegawai->id_unit;
        if($id=='panel2'){
          $inventarispanel2=Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
          ->where(['id_unit'=>$id_unit])
          ->where('B','>','0')
          ->get();

        return view('middle.panel2',['inventarispanel2'=>$inventarispanel2]);
        }
        elseif($id=='panel3'){
          $inventarispanel3=Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
          ->where(['id_unit'=>$id_unit])
          ->where('RR','>','0')
          ->get();
        return view('middle.panel3',['inventarispanel3'=>$inventarispanel3]);
        }
        else{
          $inventarispanel4= Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
          ->where(['id_unit'=>$id_unit])
          ->where('RB','>','0')
          ->get();
          return view('middle.panel4',['inventarispanel4'=>$inventarispanel4]);
        }

    }
    public function help_logout(){
      Auth::logout();
    }

}
