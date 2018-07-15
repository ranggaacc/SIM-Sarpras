<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Mail\EmailPengadaan;
use App\Http\Requests\PengadaanCek;
use App\Http\Requests\PengadaanCekEdit;
use App\Jobs\NotifPengadaanAdminJobs;
use App\ItemPengadaan;
use App\Pengadaan;
use App\KodeBarang;
use App\UnitKerja;
use App\User;
use App\TabelUserSi;
use App\Transaksi;
use Auth;
use Validator;
use Mail;
use Hashids;
// use Illuminate\Support\Facades\Mail;

class PengadaanController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
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
        $pengadaans = ItemPengadaan::where('unit',$unit->nama)->orderBy('id', 'desc')->paginate(20);
        $formpengadaans = Pengadaan::where('unit',$unit->nama)
        ->join('pegawai','pengadaan.id_pegawai','=','pegawai.id')
        ->select('pengadaan.id','id_pegawai','pegawai.nama','pengaju','id_transaksi','approvement','tanggal_pengajuan','unit','item','keterangan')
        ->orderBy('created_at', 'asc')->get();

        return view('pengadaan.index', compact('pengadaans','formpengadaans','unit'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $id_unit= Auth::user()->pegawai->id_unit;
        $unit= UnitKerja::where(['id'=>$id_unit])->first();
        return view('pengadaan.create',compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */

    public function store(PengadaanCek $request)
    {
        
        if($request->nama_barang == null){
            flash('Detail barang tidak boleh kosong')->important()->error();
            return redirect()->back();
        }
        //INPUT ID FORM
        if($request->nama_barang != null){
            $get_tabel_user_si = TabelUserSi::where('id_si','1')->where('id_role','1')->join('user', 'user.id', '=', 'tbl_user_si.id_user')->select('email')->get();
            //sendmail to all administrator
            foreach ($get_tabel_user_si as $key) {
                NotifPengadaanAdminJobs::dispatch($key->email)->delay(now()->addSeconds(5)); 
            }

            $headerform= new Pengadaan;
            $id_unit= Auth::user()->pegawai->id_unit;
            $unit= UnitKerja::where(['id'=>$id_unit])->first();
            $headerform->id_pegawai=$request->id_pegawai;
            $headerform->approvement='0';
            $headerform->nominal_type='k';
            $headerform->pengaju=$request->pengaju;
            $headerform->tanggal_pengajuan=$request->tanggal_pengajuan;            
            $headerform->unit=$unit->nama;
            $headerform->keterangan=$request->keterangan;
            $headerform->item=count($request->nama_barang);
            $headerform->save();
            $id_form = $headerform->id;

        }
       
        //INPUT ITEM FORM PENGADAAN
        
        for ($i=0; $i < count($request->nama_barang); ++$i){
                $nominal=0;
                $detailform= new ItemPengadaan;
                // $get_kode= KodeBarang::findOrFail($request->kode[$i]);
                $id_unit= Auth::user()->pegawai->id_unit;
                $unit= UnitKerja::where(['id'=>$id_unit])->first();
                $detailform->form_id=$id_form;   
                $detailform->unit=$unit->nama;   
                $detailform->nama_barang = $request->nama_barang[$i];
                $detailform->jenis= $request->jenis[$i];
                $detailform->merk= $request->merk[$i];
                $detailform->jumlah= $request->jumlah[$i];
                $detailform->perkiraan= $request->perkiraan[$i];
                $detailform->sub_total= $request->sub_total[$i];
                $detailform->save();
                $nominal+=$request->sub_total[$i];
        }

            //isi tabel transaksi status 4 "default" kalo approve ganti 3
            $transaksi = new Transaksi;
            $transaksi->id_pegawai=Auth::user()->pegawai->id;
            $transaksi->keterangan=$request->keterangan;
            $transaksi->nominal=$nominal;
            $transaksi->status="4";

            $transaksi->tanggal=$request->tanggal_pengajuan;
            $transaksi->save();
            $id_transaksi=$transaksi->id;

            $updateform=Pengadaan::findOrFail($id_form);
            $updateform->id_transaksi=$id_transaksi;
            $updateform->save();

        flash('Input pengadaan berhasil')->important()->success();
        return redirect()->route('pengadaan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $id=Hashids::decode($id);
        if($id==[]){
            return redirect()->back();
        }
        else    
        $header= Pengadaan::where('id',$id[0])->get();
        $items = ItemPengadaan::where('form_id',$id[0])->get();
        return view('pengadaan.show', compact('items','id','header'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $id=Hashids::decode($id);
        if($id==[]){
            return redirect()->back();
        }
        else    
        $headerform = Pengadaan::where('id',$id[0])->get();
        $items = ItemPengadaan::where('form_id',$id[0])->get();
        return view('pengadaan.edit', compact('items','id','headerform'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(PengadaanCekEdit $request, $id)
    {

        $this->validate($request, [
            'pengaju' => 'required',
            'tanggal_pengajuan'=> 'required|date',
        ]);

        //case edit item
        // for ($i=0; $i < count($request->kode_edit); $i++) {
        //     $detailform_edit = ItemPengadaan::findOrFail($request->id_item_edit[$i]);
        //     if($request->kode_edit[$i]!=null){

        //             $get_kode= KodeBarang::findOrFail($request->kode_edit[$i]);
        //             $detailform_edit->nama_barang = $get_kode->nama_barang;
        //             $detailform_edit->save();     
        //     }   
        // }
        //case edit item
        for ($i=0; $i < count($request->id_item_edit); $i++) 
        {
            $detailform_edit = ItemPengadaan::findOrFail($request->id_item_edit[$i]);
            $detailform_edit->nama_barang = $request->nama_barang_edit[$i];
            $detailform_edit->jenis = $request->jenis_edit[$i];
            $detailform_edit->merk= $request->merk_edit[$i];
            $detailform_edit->jumlah= $request->jumlah_edit[$i];
            $detailform_edit->perkiraan= $request->perkiraan_edit[$i];
            $detailform_edit->sub_total= $request->sub_total_edit[$i];
            $detailform_edit->save();
        }
        //case insert item
        if(count($request->nama_barang)!=null){
            for ($i=0; $i < count($request->nama_barang); $i++){
                $detailform_insert= new ItemPengadaan;                
                $detailform_insert->form_id=$request->id_form;   
                $detailform_insert->unit=$request->unit;   
                $detailform_insert->nama_barang = $request->nama_barang[$i]; 
                $detailform_insert->jenis= $request->jenis[$i];
                $detailform_insert->merk= $request->merk[$i];
                $detailform_insert->jumlah= $request->jumlah[$i];
                $detailform_insert->perkiraan= $request->perkiraan[$i];
                $detailform_insert->sub_total= $request->sub_total[$i];
                $detailform_insert->save();
                }           
        }

        

        $headerform= Pengadaan::findOrFail($request->id_form);
        $count_item=count(ItemPengadaan::where('form_id',$request->id_form)->get());
        $headerform->pengaju=$request->pengaju;
        $headerform->tanggal_pengajuan=$request->tanggal_pengajuan;
        $headerform->keterangan=$request->keterangan;
        $headerform->item=$count_item;
        $headerform->save();

        flash('Edit pengadaan berhasil')->important()->success();
        return redirect()->route('pengadaan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $pengadaan = Pengadaan::where(['id'=>$id]);
        $pengadaan->delete();
        flash('Delete pengadaan berhasil')->important()->success();
        return redirect()->route('pengadaan.index');
    }
    public function destroy_item($id)
    {
        $item_pengadaan = ItemPengadaan::findOrFail($id);
        $id_form = $item_pengadaan->form_id; 
        $item_pengadaan->delete();
        $pengadaan = Pengadaan::findOrFail($id_form);
        $count_item=count(ItemPengadaan::where('form_id',$id_form)->get());
        $pengadaan->item=$count_item;
        $pengadaan->save();
        flash('Delete barang berhasil')->important()->success();
        return redirect()->back();
    }
}
