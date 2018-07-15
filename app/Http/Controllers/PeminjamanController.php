<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Inventaris;
use App\Peminjaman;
use App\Peminjam;
use App\ItemPeminjaman;
use App\Pengadaan;
use App\UnitKerja;
use App\Ruangan;
use App\TabelUserSi;
use Carbon\Carbon;
use App\Jobs\NotifPeminjamanAdminJobs;
use DB;
use Auth;
use Hashids;
use Validator;
use File;


class PeminjamanController extends Controller {

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
        $this->middleware('roles:4');

    }    
    public function index()
    {
        $ruangans= Ruangan::where('status_peminjaman','1')->get();

        $peminjamans= Peminjaman::where('id_user',Auth::user()->id)
        ->whereDate('waktu_mulai', '>=', date('Y-m-d'))
        ->join('user','peminjaman.id_user','=','user.id')
        ->join('peminjam','peminjaman.id_user','=','peminjam.user_id')
        ->join('ruangan','peminjaman.id_ruangan','=','ruangan.id')
        ->select('peminjaman.id as id_peminjaman','status','id_user','nama','peminjam.email','tanggal_pengajuan','waktu_mulai','waktu_selesai','peminjaman.keterangan as keterangan_peminjaman','nama_ruang','ruangan.gambar as gambar_ruangan','file1','file2')
        ->get();

        $all_peminjamans= Peminjaman::whereDate('waktu_mulai', '>=', date('Y-m-d'))
        ->where('status','=','1')
        ->join('user','peminjaman.id_user','=','user.id')
        ->join('peminjam','peminjaman.id_user','=','peminjam.user_id')
        ->join('ruangan','peminjaman.id_ruangan','=','ruangan.id')
        ->select('peminjaman.id as id_peminjaman','status','id_user','nama','peminjam.email','tanggal_pengajuan','waktu_mulai','waktu_selesai','peminjaman.keterangan as keterangan_peminjaman','nama_ruang','ruangan.gambar as gambar_ruangan','file1','file2')
        ->get();

        return view('peminjaman.index',compact('ruangans','peminjamans','all_peminjamans'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $ruangans = Ruangan::where('status_peminjaman','1')->get();
        return view('peminjaman.create', compact('ruangans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function cek_tanggal($get_peminjaman,$jam_mulai,$jam_selesai){
            $penanda = 0;
            foreach ($get_peminjaman as $value) {
                if (strtotime($value->waktu_mulai) >= strtotime($jam_mulai) and strtotime($value->waktu_mulai) <= strtotime($jam_selesai)) {
                    $penanda = $penanda + 1;
                } else if (strtotime($value->waktu_mulai) < strtotime($jam_mulai) and strtotime($value->waktu_selesai) >= strtotime($jam_mulai)) {
                    $penanda = $penanda + 1;
                } else if (strtotime($value->waktu_mulai) <= strtotime($jam_mulai) and strtotime($value->waktu_selesai) > strtotime($jam_selesai)) {
                    $penanda = $penanda + 1;
                } else if (strtotime($value->waktu_mulai) >= strtotime($jam_mulai) and strtotime($value->waktu_selesai) <= strtotime($jam_selesai)) {
                    $penanda = $penanda + 1;
                }
            }
            return $penanda;       
    }
    public function cek_tanggal_edit($id_peminjaman,$id_ruangan,$jam_mulai,$jam_selesai){
        
        $get_peminjaman=Peminjaman::where('id_ruangan',$id_ruangan)
                    ->where( function ($query) use ($id_peminjaman)
                    {
                        $query->where('id','!=',$id_peminjaman)->orWhereNull('id');
                    })
                    ->where('status','1')
                    ->get();
            $penanda = 0;
            foreach ($get_peminjaman as $value) {
                if (strtotime($value->waktu_mulai) >= strtotime($jam_mulai) and strtotime($value->waktu_mulai) <= strtotime($jam_selesai)) {
                    $penanda = $penanda + 1;
                } else if (strtotime($value->waktu_mulai) < strtotime($jam_mulai) and strtotime($value->waktu_selesai) >= strtotime($jam_mulai)) {
                    $penanda = $penanda + 1;
                } else if (strtotime($value->waktu_mulai) <= strtotime($jam_mulai) and strtotime($value->waktu_selesai) > strtotime($jam_selesai)) {
                    $penanda = $penanda + 1;
                } else if (strtotime($value->waktu_mulai) >= strtotime($jam_mulai) and strtotime($value->waktu_selesai) <= strtotime($jam_selesai)) {
                    $penanda = $penanda + 1;
                }
            }
            return $penanda;       
    }
    public function store(Request $request)
    {

        $this->validate($request, [
            'id_ruangan'=> 'required',
            'tanggal_pengajuan'=> 'required|date',
            'waktu_mulai'=> 'required',
            'waktu_selesai'=> 'required',
            'keterangan'=> 'required|max:300',
            'file1' => 'mimes:jpg,jpeg,png,pdf,docx,doc|max:5000',
            'file2' => 'mimes:jpg,jpeg,png,pdf,docx,doc|max:5000',
        ]);

        if (strtotime($request->waktu_mulai) >= strtotime($request->waktu_selesai)) {
                flash('Waktu selesai harus lebih dari waktu mulai')->important()->error();
                return redirect()->back();
        }
        $get_peminjaman = Peminjaman::where('id_ruangan',$request->id_ruangan)
                        ->get();
        
        if($get_peminjaman==null){
            $get_tabel_user_si = TabelUserSi::where('id_si','1')->where('id_role','1')->join('user', 'user.id', '=', 'tbl_user_si.id_user')->select('email')->get();
            
            foreach ($get_tabel_user_si as $key) {
                NotifPeminjamanAdminJobs::dispatch($key->email)->delay(now()->addSeconds(5)); 
            }
            $peminjaman = new Peminjaman;
            $peminjaman->id_user= Auth::user()->id;
            $peminjaman->id_ruangan= $request->id_ruangan;
            $peminjaman->status= "0";
            $peminjaman->tanggal_pengajuan=$request->tanggal_pengajuan;
            $peminjaman->waktu_mulai=Carbon::parse($request->waktu_mulai);
            $peminjaman->waktu_selesai=Carbon::parse($request->waktu_selesai);
            $peminjaman->keterangan=$request->keterangan;
            if ($request->hasFile('file1')) {
                $imageTempName = $request->file('file1')->getPathname();
                $imageName = $request->file('file1')->getClientOriginalName();
                $path = base_path() . '/public/upload/file/';
                $request->file('file1')->move($path , $imageName);
                $peminjaman->file1 = '/upload/file/'.$imageName;
            }
            if ($request->hasFile('file2')) {
                $imageTempName = $request->file('file2')->getPathname();
                $imageName = $request->file('file2')->getClientOriginalName();
                $path = base_path() . '/public/upload/file/';
                $request->file('file2')->move($path , $imageName);
                $peminjaman->file2 = '/upload/file/'.$imageName;
            }
            $peminjaman->save();
            flash('Input peminjaman berhasil')->important()->success();
            return redirect()->route('peminjaman.index');                
        }
        else{
            $get_tabel_user_si = TabelUserSi::where('id_si','1')->where('id_role','1')->join('user', 'user.id', '=', 'tbl_user_si.id_user')->select('email')->get();
            
            foreach ($get_tabel_user_si as $key) {
                NotifPeminjamanAdminJobs::dispatch($key->email)->delay(now()->addSeconds(5)); 
            }


            $jam_mulai=Carbon::parse($request->waktu_mulai);
            $jam_selesai=Carbon::parse($request->waktu_selesai);
            $penanda=$this->cek_tanggal($get_peminjaman,$jam_mulai,$jam_selesai);
            if($penanda==0){
                $peminjaman = new Peminjaman;
                $peminjaman->id_user= Auth::user()->id;
                $peminjaman->id_ruangan= $request->id_ruangan;
                $peminjaman->status= "0";
                $peminjaman->tanggal_pengajuan=$request->tanggal_pengajuan;
                $peminjaman->waktu_mulai=Carbon::parse($request->waktu_mulai);
                $peminjaman->waktu_selesai=Carbon::parse($request->waktu_selesai);
                $peminjaman->keterangan=$request->keterangan;
                    if ($request->hasFile('file1')) {
                        $imageTempName = $request->file('file1')->getPathname();
                        $imageName = $request->file('file1')->getClientOriginalName();
                        $path = base_path() . '/public/upload/file/';
                        $request->file('file1')->move($path , $imageName);
                        $peminjaman->file1 = '/upload/file/'.$imageName;
                    }
                    if ($request->hasFile('file2')) {
                        $imageTempName = $request->file('file2')->getPathname();
                        $imageName = $request->file('file2')->getClientOriginalName();
                        $path = base_path() . '/public/upload/file/';
                        $request->file('file2')->move($path , $imageName);
                        $peminjaman->file2 = '/upload/file/'.$imageName;
                    }
                $peminjaman->save();
                flash('Input peminjaman berhasil')->important()->success();
                return redirect()->route('peminjaman.index');                     
            }
            else{
                flash('Terdapat jadwal pada tanggal tersebut')->important()->error();
                return redirect()->back();
            } 
        }



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
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
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
        $peminjaman = Peminjaman::findOrFail($id[0]);
        return view('peminjaman.edit', compact('peminjaman'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'tanggal_pengajuan'=> 'required|date',
            'waktu_mulai'=> 'required',
            'waktu_selesai'=> 'required',
            'keterangan'=> 'required|max:300',
            'file' => 'mimes:jpg,jpeg,png,pdf,docx,doc,zip,rar',
        ]);

        if (strtotime($request->waktu_mulai) >= strtotime($request->waktu_selesai)) {
                flash('Waktu selesai harus lebih dari waktu mulai')->error();
                return redirect()->back();
        }
        if ($request->input('id_ruangan')!=null) {
            $get_peminjaman = Peminjaman::where('id_ruangan',$request->id_ruangan)->get();
            $id_ruangan= $request->id_ruangan;
        }
        else{
            $get_peminjaman = Peminjaman::where('id_ruangan',$request->previous_kode)->get();
            $id_ruangan= $request->previous_kode;
        }
        $jam_mulai=Carbon::parse($request->waktu_mulai);
        $jam_selesai=Carbon::parse($request->waktu_selesai);
        $peminjaman = Peminjaman::findOrFail($id);
        if($peminjaman->waktu_mulai==$jam_mulai && $peminjaman->waktu_selesai==$jam_selesai){
            $peminjaman->id_user= Auth::user()->id;
            $peminjaman->id_ruangan=$id_ruangan;      
            $peminjaman->tanggal_pengajuan=$request->tanggal_pengajuan;
            $peminjaman->waktu_mulai=Carbon::parse($request->waktu_mulai);
            $peminjaman->waktu_selesai=Carbon::parse($request->waktu_selesai);
            $peminjaman->keterangan=$request->keterangan;
                    if ($request->hasFile('file1')) {
                        $imageTempName = $request->file('file1')->getPathname();
                        $imageName = $request->file('file1')->getClientOriginalName();
                        $path = base_path() . '/public/upload/file/';
                        $request->file('file1')->move($path , $imageName);
                        $peminjaman->file1 = '/upload/file/'.$imageName;
                    }
                    if ($request->hasFile('file2')) {
                        $imageTempName = $request->file('file2')->getPathname();
                        $imageName = $request->file('file2')->getClientOriginalName();
                        $path = base_path() . '/public/upload/file/';
                        $request->file('file2')->move($path , $imageName);
                        $peminjaman->file2 = '/upload/file/'.$imageName;
                    }
            $peminjaman->save();
            flash('Edit peminjaman berhasil')->success();
            return redirect()->route('peminjaman.index');  

        }
        else{
            $penanda=$this->cek_tanggal_edit($id,$id_ruangan,$jam_mulai,$jam_selesai);
            $peminjaman->id_ruangan=$id_ruangan;
            if($penanda==0){
                $peminjaman->id_user= Auth::user()->id;
                $peminjaman->id_ruangan=$id_ruangan;
                $peminjaman->tanggal_pengajuan=$request->tanggal_pengajuan;
                $peminjaman->waktu_mulai=Carbon::parse($request->waktu_mulai);
                $peminjaman->waktu_selesai=Carbon::parse($request->waktu_selesai);
                $peminjaman->keterangan=$request->keterangan;
                    if ($request->hasFile('file1')) {
                        $imageTempName = $request->file('file1')->getPathname();
                        $imageName = $request->file('file1')->getClientOriginalName();
                        $path = base_path() . '/public/upload/file/';
                        $request->file('file1')->move($path , $imageName);
                        $peminjaman->file = '/upload/file/'.$imageName;
                    }
                    if ($request->hasFile('file2')) {
                        $imageTempName = $request->file('file2')->getPathname();
                        $imageName = $request->file('file2')->getClientOriginalName();
                        $path = base_path() . '/public/upload/file/';
                        $request->file('file2')->move($path , $imageName);
                        $peminjaman->file = '/upload/file/'.$imageName;
                    }
                $peminjaman->save();
                flash('Edit peminjaman berhasil')->success();
                return redirect()->route('peminjaman.index');                     
            }
            else{
                flash('Terdapat jadwal lain')->error();
                return redirect()->back();
            }
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = Peminjaman::findOrFail($id);
        $user->delete();
        flash('Delete peminjaman berhasil')->success();
        return redirect()->route('peminjaman.index');
    }

}
