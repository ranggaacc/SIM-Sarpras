<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\TabelUserSi;
use App\Pengadaan;
use App\Peminjam;
use App\Pegawai;
use App\UnitKerja;
use App\User;
use App\Role;
use DB;
use Auth;
use Hashids;
use Validator;

class PeminjamController extends Controller {

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
    public function index()
    {

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
    public function addPeminjam(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username_peminjam' => 'required|string|unique:user,username|max:255',
            'email' => 'required|string|email|max:255',
            'password_peminjam' => 'required|min:6|confirmed',
            'jenis_kelamin'=> 'required',
            'no_hp'=> 'required|max:13',
            'telepon'=> 'required|max:13',
            'image' => 'mimes:jpeg,bmp,jpg,png|max:5000'
        ]);
        if ($validator->fails()) {
            flash('Registrasi gagal !! cek kembali form anda')->important()->error();
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
                        
        }
        //input ke table user ;
        $user = new User();
        $user->id_pegawai='0';
        $user->username=$request->username_peminjam;
        $user->email=$request->email;
        $user->password=bcrypt($request->password_peminjam);
        $user->save();
        $user_id = $user->id;

        //input ke table peminjam ;
        $peminjam = new Peminjam();
        $peminjam->user_id=$user_id;
        $peminjam->nama=$request->nama;
        $peminjam->email=$request->email;
        $peminjam->jenis_kelamin=$request->jenis_kelamin;
        $peminjam->nomor_hp=$request->no_hp;
        $peminjam->telepon=$request->telepon;

        if(count($request->image)>0){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $request->file('image')->move("imageProfil/",$fileName);
            $peminjam->gambar = $fileName;
        }
        
        $peminjam->save();
           

        //input ke table user SI
        $tbl_user_si= new TabelUserSi;
        $tbl_user_si->id_user=$user_id;
        $tbl_user_si->id_si="1";
        $tbl_user_si->id_role="4";
        $tbl_user_si->save();
        flash('Registrasi berhasil')->important()->success();
        return view('auth.login');
    }

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

    }

}
