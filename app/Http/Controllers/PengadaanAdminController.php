<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EmailPengadaan;
use App\UnitKerja;
use App\ItemPengadaan;
use App\Pengadaan;
use App\User;
use App\Pegawai;
use App\Transaksi;
use App\Jobs\ProcessMailPengadaan;
use Auth;
use Validator;
use Mail;
use Hashids;
// use Illuminate\Support\Facades\Mail;

class PengadaanAdminController extends Controller {
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
        $pengadaans = ItemPengadaan::all();
        $formpengadaans = Pengadaan::orderBy('created_at', 'desc')->get();
        
        
        return view('pengadaan_admin.index', compact('pengadaans','formpengadaans'));
    }
    public function sendMail($pegawai,$tanggal_pengajuan){

        Mail::raw('Dear Bapak/Ibu. '.$pegawai->nama.',

        Pengajuan anda pada tanggal: '.date('j F Y', strtotime($tanggal_pengajuan)).' telah disetujui. Untuk detail lebih lanjut silahkan
        datang ke frontdesk Biofarmaka.
                       
        Pusat Studi Biofarmaka Tropika IPB (TROP BRC)
        SIM-SARPRAS', function($message) use ($pegawai)
        {
            $message->from("biofarmakaipb@gmail.com", "Administrator SIM-SARPRAS");
            $message->to($pegawai->email);           
            $message->subject("--Pengajuan Pengadaan Sarpras--");
        });

    }



    
    public function sendMailDecline($pegawai,$tanggal_pengajuan){

        Mail::raw('Dear Bapak/Ibu. '.$pegawai->nama.',

        Pengajuan anda pada tanggal: '.date('j F Y', strtotime($tanggal_pengajuan)).' ditolak. Untuk detail lebih lanjut silahkan
        datang ke frontdesk Biofarmaka.
                       
        Pusat Studi Biofarmaka Tropika IPB (TROP BRC)
        SIM-SARPRAS', function($message) use ($pegawai)
        {
            $message->from("biofarmakaipb@gmail.com", "Administrator SIM-SARPRAS");
            $message->to($pegawai->email);           
            $message->subject("--Pengajuan Pengadaan Sarpras--");
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
    public function approvement(Request $request, $id) {

            $this->validate($request, [
                'approvement' => 'required'
            ]);

            $pegawai = Pegawai::where('id',$request->id_pegawai)->first();
            /*Kirim Email Pengajuan Sarpras*/
            // Mail::to($get_email)->send(new EmailPengadaan($pegawai));
            // $is_conn=$this->is_connected();
            $approvement=$request->approvement;
            $pengadaan = Pengadaan::findOrFail($id);
            $pengadaan->approvement = $request->input("approvement");
            $pengadaan->save();
            //$this->dispatch((new ProcessMailPengadaan($pegawai,$request->tanggal_pengajuan,$approvement)));
            ProcessMailPengadaan::dispatch($pegawai,date('j F Y', strtotime($request->tanggal_pengajuan)),$approvement,$pengadaan)->delay(now()->addSeconds(5));
            //update tabel transaksi 
                $transaksi=Transaksi::findOrFail($request->id_transaksi);
                $transaksi->status="3";
                $transaksi->save();

            flash('Memperbaharui status berhasil')->important()->success();
            return redirect()->route('pengadaanadmin.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
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
        $id2=Hashids::decode($id);
        if($id2==[]){
            return redirect()->back();
        }
        else          
        $id=$id2[0];
        $header= Pengadaan::where('id',$id)->first();
        $items = ItemPengadaan::where('form_id',$id)->get();
        return view('pengadaan_admin.show', compact('items','id','header'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

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
        $pengadaan = Pengadaan::where(['id'=>$id]);
        $pengadaan->delete();
        flash('Delete pengadaan berhasil')->important()->success();
        return redirect()->route('pengadaanadmin.index');
    }

}
