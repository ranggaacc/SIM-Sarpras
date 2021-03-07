<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Maatwebsite\Excel\Facades\Excel;
use App\Inventaris;
use App\KodeBarang;
use App\UnitKerja;
use App\Pengadaan;
use App\Ruangan;
use App\Testing;
use Auth;
use Hashids;
use Validator;



class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct(){

    //     $this->middleware('auth');
    //     $this->middleware('roles:UIH');

        

    // }
    // public function __construct()
    // {
    //     //defining our middleware for this controller
    //     $this->middleware('guest:admin',['except' => ['logout']]);
    // }
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
        $this->middleware('roles:2');

    }  
    public function index()
    {
        $id_unit= Auth::user()->pegawai->id_unit;
        $unit= UnitKerja::where(['id'=>$id_unit])->first();
        $inventariss= Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->select('inventaris.id','kode_barang','inventaris.nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi','gambar')
        ->where(function($query) use ($id_unit){
            $query->where(['id_unit'=>$id_unit])
            ->where('deleted_at',null);
        })
        ->get();

        $inventaris_trashed= Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->select('inventaris.id','kode_barang','inventaris.nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi','gambar')
        ->where(function($query) use ($id_unit){
            $query->where(['id_unit'=>$id_unit]);
        })
        ->onlyTrashed()
        ->get();
        // dd($inventaris_trashed);
        
        return view('middle.tables',compact('inventariss','unit','inventaris_trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data= KodeBarang::all();
        $id_unit= Auth::user()->pegawai->id_unit;
        $lokasi= Ruangan::all();
        $unit= UnitKerja::where(['id'=>$id_unit])->first();
        return view('middle.forms',compact('data','unit','lokasi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $array = explode(' ', $string, 2);
        // $input->kode_barang=$array[0];
        // $input->nama_barang=$array[1];
        $this->validate($request, [
            'kode_barang'=> 'required|max:100',
            'nama_barang'=> 'max:40',
            'merk_barang'=> 'max:20',
            'tahun_barang'=> 'required|max:4',
            'harga_satuan'=> 'max:10',
            'jumlah_barang'=> 'required|max:10',
            'satuan'=> 'required|max:15',
            'jumlah_harga'=> 'max:20',
            'sumber_dana'=> 'max:20',
            'b'=> 'max:5',
            'rr'=> 'max:5',
            'rb'=> 'max:5',
            'keterangan'=> 'max:300',
            'lokasi'=> 'required|max:30',
            'image'=> 'mimes:jpeg,bmp,png',
        ]);

        $input= new Inventaris;
        $id_unit= Auth::user()->pegawai->id_unit;
        $input->id_unit=$id_unit;
        $input->id_kode_barang=$request->kode_barang;
        $input->nama_barang=$request->nama_barang;
        $input->merk_barang=$request->merk_barang;
        $input->tahun_barang=$request->tahun_barang;
        $input->harga_satuan=$request->harga_satuan;
        $input->jumlah_barang=$request->jumlah_barang;
        $input->satuan=$request->satuan;
        $input->jumlah_harga=$request->jumlah_harga;
        $input->sumber_dana=$request->sumber_dana;
        $input->lokasi=$request->lokasi;

        $input->keterangan=$request->keterangan;
        $input->B=$request->b;
        $input->RR=$request->rr;
        $input->RB=$request->rb;
        
        if(count($request->image)>0){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $request->file('image')->move("imageInventaris/",$fileName);
            $input->gambar = $fileName;
        }
        $input->save();
        flash('Input inventaris berhasil')->important()->success();
        // return redirect()->route('inventaris.index');
        return redirect()->route('inventaris.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $inventaris=Inventaris::find($id);
        $lokasi=Ruangan::all();
        return view('uih.formsEdit',compact('inventaris','lokasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $id=Hashids::decode($id);
        if($id==[]){
            return redirect()->back();
        }
        else              
        $inventaris=Inventaris::findOrFail($id[0]);
        $id_unit= Auth::user()->pegawai->id_unit;
        $lokasi=Ruangan::all();
        $lokasi_sekarang=Ruangan::where('kode_ruang',$inventaris->lokasi)->first();
        $unit= UnitKerja::where(['id'=>$id_unit])->first();
        $kode_barang= KodeBarang::where('id',$inventaris->id_kode_barang)->first();
        return view('middle.edit',['inventaris' => $inventaris,'kode_barang'=>$kode_barang,'unit'=>$unit,'lokasi'=>$lokasi,'lokasi_sekarang'=>$lokasi_sekarang]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $this->validate($request, [
            'previous_kode'=> 'max:100',
            'nama_barang'=> 'max:40',
            'merk_barang'=> 'max:20',
            'tahun_barang'=> 'max:4',
            'harga_satuan'=> 'max:10',
            'jumlah_barang'=> 'max:4',
            'satuan'=> 'max:15',
            'jumlah_harga'=> 'max:20',
            'sumber_dana'=> 'max:20',
            'b'=> 'max:5',
            'rr'=> 'max:5',
            'rb'=> 'max:5',
            'keterangan'=> 'max:300',
            'lokasi'=> 'required|max:30',
            'image'=> 'mimes:jpeg,bmp,png',
        ]);


        $input = Inventaris::findOrFail($id);
        $input->id_unit=Auth::user()->pegawai->id_unit;

        if ($request->input('kode_barang')!=null) {
            $input->id_kode_barang=$request->kode_barang;
        }
        else{
            $input->id_kode_barang=$request->previous_kode;
        }
        $input->nama_barang=$request->nama_barang;
        $input->merk_barang=$request->merk_barang;
        $input->tahun_barang=$request->tahun_barang;
        $input->harga_satuan=$request->harga_satuan;
        $input->jumlah_barang=$request->jumlah_barang;
        $input->satuan=$request->satuan;
        $input->jumlah_harga=$request->jumlah_harga;
        $input->sumber_dana=$request->sumber_dana;
        $input->lokasi=$request->lokasi;

        $input->keterangan=$request->keterangan;
        $input->B=$request->b;
        $input->RR=$request->rr;
        $input->RB=$request->rb;

        if(count($request->image)>0){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $request->file('image')->move("imageInventaris/",$fileName);
            $input->gambar = $fileName;
        }
        $input->save();
        flash('Edit inventaris berhasil')->important()->success();
        return redirect()->route('inventaris.index');     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $id=Hashids::decode($id);
        $inventaris= Inventaris::find($id[0]);
        $inventaris->delete();
        flash('Delete inventaris berhasil')->important()->success();
        return redirect()->back();
    }

    public function force_destroy($id)
    {

        $inventaris= Inventaris::withTrashed()
        ->where('id', $id)
        ->forceDelete();
        flash('Delete inventaris berhasil')->important()->success();
        return redirect()->back();
    }    

    public function force_destroy_all()
    {

        $inventaris= Inventaris::withTrashed()
        ->where('deleted_at','<>',null)
        ->forceDelete();
        flash('Semua sampah data inventaris berhasil dihapus')->important()->success();
        return redirect()->back();
    }  

    public function restore_id($id)
    {
        // dd($id);
        $inventaris= Inventaris::withTrashed()
        ->where('id', $id)
        ->restore();
        flash('Data inventaris berhasil dipulihkan')->important()->success();
        return redirect()->back();
    }

    public function restore_all()
    {
        // dd($id);
        $inventaris= Inventaris::withTrashed()
        ->where('deleted_at','<>',null)
        ->restore();
        flash('Semua sampah data inventaris berhasil dipulihkan')->important()->success();
        return redirect()->back();
    }

    public function importExcel(Request $request)
    {

        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            //get unit
            if(Auth::user()->user_si[0]->id_role=='1'){
                $id_unit='10';//untuk unit sekretariat
            }
            else {
                $id_unit= Auth::user()->pegawai->id_unit;//selain sekretariat
            }
            //skip yang pertama karena null
            $data=$data->slice(1,$data->count());
            
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    
                    $value->kode_barang=KodeBarang::select('id')->where('kode_barang',$value->kode_barang)->first();
                    if($value->kode_barang==null){
                        flash('Cek kembali NOTE pada contoh file dan pastikan kode barang pada data tidak null atau kosong')->important()->error();
                        return redirect()->back();
                    }
                    else{ 
                        $insert[] = ['id_kode_barang' => $value->kode_barang->id, 'id_unit' => $id_unit,'nama_barang'=>$value->nama_barang,'merk_barang'=>$value->merk_barang,'tahun_barang'=>$value->tahun_pembuatan,'harga_satuan'=>$value->harga_satuan,'jumlah_barang'=>$value->jumlah_barang,'satuan'=>$value->satuan,'jumlah_harga'=>$value->jumlah_harga,'sumber_dana'=>$value->sumber_dana,'B'=>$value->b,'RR'=>$value->rr,'RB'=>$value->rb,'lokasi'=>$value->lokasi,'created_at'=>date('Y-m-d')];
                    }
                }
                // dd($insert);
                if(!empty($insert)){
                    DB::table('inventaris')->insert($insert);
                    flash('Import data berhasil')->important()->success();
                    return back();
                }
            }
        }
        return back();
    }
//, 'id_unit' => '1','nama_barang'=>$value->nama_barang,'merk_barang'=>$value->merk_barang,'tahun_barang'=>$value->tahun_pembuatan,'harga_satuan'=>$value->harga_satuan,'jumlah_barang'=>$value->jumlah_barang,'satuan'=>$value->satuan,'jumlah_harga'=>$value->jumlah_harga,'sumber_dana'=>$value->sumber_dana,'B'=>$value->b,'RR'=>$value->rr,'RB'=>$value->rb,'lokasi'=>$value->lokasi
    // public function importExcel(Request $request)
    // {

 // if(Input::hasFile('import_file')){
 //            $path = Input::file('import_file')->getRealPath();
 //            $data = Excel::load($path, function($reader) {
 //            })->get();
 //            if(!empty($data) && $data->count()){
 //                foreach ($data as $key => $value) {
 //                    $kodebarang=KodeBarang::select('id')->where('kode_barang',$value->title)->first();
 //                    $insert[] = ['title' => $kodebarang->id, 'description' => $value->description];
 //                }
 //                if(!empty($insert)){
 //                    DB::table('testing')->insert($insert);
 //                    flash('Import data berhasil')->important()->success();
 //                    return back();
 //                }
 //            }
 //        }
    //     return back();
    // }   
}
