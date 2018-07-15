<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Inventaris;
use App\Peminjaman;
use App\Peminjam;
use App\ItemPeminjaman;
use App\UnitKerja;
use App\Ruangan;
use Carbon\Carbon;
use App\Jobs\ProcessMailPeminjaman;
use Auth;
use Hashids;
use Validator;
use Mail;

class PeminjamanAdminController extends Controller {

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
        $this->middleware('roles:1');

    }    
    public function index()
    {
        $ruangans= Ruangan::all();

        $peminjamans= Peminjaman::whereDate('waktu_mulai', '>=', date('Y-m-d'))
        ->where('status','=','0')
        ->join('user','peminjaman.id_user','=','user.id')
        ->join('peminjam','peminjaman.id_user','=','peminjam.user_id')
        ->join('ruangan','peminjaman.id_ruangan','=','ruangan.id')
        ->select('peminjaman.id as id_peminjaman','status','id_user','nama','peminjam.email','tanggal_pengajuan','waktu_mulai','waktu_selesai','peminjaman.keterangan as keterangan_peminjaman','nama_ruang','ruangan.gambar as gambar_ruangan','file1','file2','id_ruangan','nomor_hp','telepon')
        ->get();

        $all_peminjamans= Peminjaman::whereDate('waktu_mulai', '>=', date('Y-m-d'))
        ->where('status','=','1')
        ->join('user','peminjaman.id_user','=','user.id')
        ->join('peminjam','peminjaman.id_user','=','peminjam.user_id')
        ->join('ruangan','peminjaman.id_ruangan','=','ruangan.id')
        ->select('peminjaman.id as id_peminjaman','status','id_user','nama','peminjam.email','tanggal_pengajuan','waktu_mulai','waktu_selesai','peminjaman.keterangan as keterangan_peminjaman','nama_ruang','ruangan.gambar as gambar_ruangan','file1','file2','id_ruangan')
        ->get();



        return view('peminjamanadmin.index',compact('ruangans','peminjamans','all_peminjamans'));
    }
   public function sendMailApprove($peminjam,$tanggal_pengajuan){

        Mail::raw('Dear Bapak/Ibu. '.$peminjam->nama.',

        Pengajuan peminjaman ruangan anda pada tanggal: '.date('j F Y', strtotime($tanggal_pengajuan)).' telah disetujui. Untuk detail lebih lanjut silahkan
        datang ke frontdesk Biofarmaka.
                       
        Pusat Studi Biofarmaka Tropika IPB (TROP BRC)
        SIM-SARPRAS', function($message) use ($peminjam)
        {
            $message->from("biofarmakaipb@gmail.com", "Administrator SIM-SARPRAS");
            $message->to($peminjam->email);           
            $message->subject("--Pengajuan Peminjaman Ruangan Biofarmaka--");
            // $message->markdown('emails.pengadaan.success');
            //$message->attach(asset($layanan->file_skdu), ["as" => "skdu.pdf", "mime" => "pdf"]);
        });

    }
    public function sendMailDecline($peminjam,$tanggal_pengajuan){

        Mail::raw('Dear Bapak/Ibu. '.$peminjam->nama.',

        Pengajuan peminjaman ruangan anda pada tanggal: '.date('j F Y', strtotime($tanggal_pengajuan)).' ditolak.
                       
        Pusat Studi Biofarmaka Tropika IPB (TROP BRC)
        SIM-SARPRAS', function($message) use ($peminjam)
        {
            $message->from("biofarmakaipb@gmail.com", "Administrator SIM-SARPRAS");
            $message->to($peminjam->email);           
            $message->subject("--Pengajuan Peminjaman Ruangan Biofarmaka--");
            // $message->markdown('emails.pengadaan.success');
            //$message->attach(asset($layanan->file_skdu), ["as" => "skdu.pdf", "mime" => "pdf"]);
        });

    }
    public function is_connected()
    {
        $connected = @fsockopen("www.example.com", 80); 
                                            //website, port  (try 80 or 443)
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;

    }
    public function cek_tanggal($id_ruangan,$id_peminjaman){
        $get_peminjaman=Peminjaman::where('id_ruangan',$id_ruangan)
        ->where('status','1')
        ->get();
        $peminjaman=Peminjaman::find($id_peminjaman);
        $penanda=0;
        foreach ($get_peminjaman as $value) {
                 if (strtotime($value->waktu_mulai) >= strtotime($peminjaman->waktu_mulai) and strtotime($value->waktu_mulai) <= strtotime($peminjaman->waktu_selesai)) {
                    $penanda = $penanda + 1;
                } else if (strtotime($value->waktu_mulai) < strtotime($peminjaman->waktu_mulai) and strtotime($value->waktu_selesai) >= strtotime($peminjaman->waktu_mulai)) {
                    $penanda = $penanda + 1;
                } else if (strtotime($value->waktu_mulai) <= strtotime($peminjaman->waktu_mulai) and strtotime($value->waktu_selesai) > strtotime($peminjaman->waktu_selesai)) {
                    $penanda = $penanda + 1;
                } else if (strtotime($value->waktu_mulai) >= strtotime($peminjaman->waktu_mulai) and strtotime($value->waktu_selesai) <= strtotime($peminjaman->waktu_selesai)) {
                    $penanda = $penanda + 1;
                }           
        }
        return $penanda;  

    }
    public function approvement(Request $request, $id) {

            $this->validate($request, [
                'approvement' => 'required'
            ]);

            $peminjam = Peminjam::where('user_id',$request->id_user)
            ->first();
            /*Kirim Email Peminjaman Sarpras*/
            // $is_conn=$this->is_connected();
            $approvement=$request->approvement;
            $penanda=$this->cek_tanggal($request->id_ruangan,$request->id_peminjaman);
            if($penanda>0){
                flash('Terdapat jadwal pada tanggal tersebut yang telah anda setujui sebelumnya')->error();
                return redirect()->back();
            }
            else{
                //dd($peminjam);
                //$this->sendMailApprove($peminjam,$tanggal_pengajuan);
                // $this->dispatch((new ProcessMailPeminjaman($peminjam,$request->tanggal_pengajuan,$approvement)))->delay(now()->addSeconds(10)); 
                $peminjaman=Peminjaman::findOrFail($id);

                ProcessMailPeminjaman::dispatch($peminjam,$approvement,$peminjaman)->delay(now()->addSeconds(5)); 
                $peminjaman = Peminjaman::findOrFail($id);
                $peminjaman->status = $request->input("approvement");
                $peminjaman->save();
            }
            
            // else if($request->approvement =='2') {
            //         //$this->dispatch((new ProcessMailPeminjaman($peminjam,$tanggal_pengajuan,$approvement))); 
            //         $this->sendMailDecline($peminjam,$request->tanggal_pengajuan);
            //         ProcessMailPeminjaman::dispatch($peminjam,$tanggal_pengajuan,$approvement)->delay(now()->addSeconds(5));
            //     $peminjaman = Peminjaman::findOrFail($id);
            //     $peminjaman->status = $request->input("approvement");
            //     $peminjaman->save();
            // }
            flash('Memperbaharui status berhasil')->important()->success();
            return redirect()->route('peminjamanadmin.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $items = Ruangan::all();
        return view('peminjamanadmin.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */

    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
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
        $peminjaman = Peminjaman::findOrFail($id[0]);
        return view('peminjamanadmin.edit', compact('peminjaman'));
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
        flash('Delete peminjaman berhasil')->important()->success();
        return redirect()->route('peminjamanadmin.index');
    }

}
