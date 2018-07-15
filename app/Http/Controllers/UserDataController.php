<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\TabelUserSi;
use App\Pengadaan;
use App\Pegawai;
use App\UnitKerja;
use App\User;
use App\Role;
use DB;
use Auth;
use Hashids;

class UserDataController extends Controller {

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
        // $pegawai=Pegawai::find(3);
        // dd($pegawai->unit_kerja);
        $users = User::join('pegawai','user.id_pegawai','=','pegawai.id')
        ->join('tbl_user_si','user.id','=','tbl_user_si.id_user')
        ->join('role','tbl_user_si.id_role','=','role.id')
        ->join('unit_kerja','pegawai.id_unit','=','unit_kerja.id')
        ->where('tbl_user_si.id_si','=','1')
        ->select('user.id as id_user','pegawai.id as id_pegawai','id_unit','pegawai.nama as nama_pegawai','unit_kerja.nama as nama_unit','username','pegawai.email','created_at','gelar_depan','gelar_belakang','no_ktp','tanggal_lahir','tempat_lahir','jenis_kelamin','agama','status_kawin','nomor_hp','telepon','faks','alamat','nama_role','id_si','gambar')
        ->get();
        // dd($users);
        return view('userdata.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $pegawais=Pegawai::all();
        $roles=Role::whereNotIn('nama_role',['PEMINJAM','PENELITI'])->get();

        return view('userdata.create',compact('pegawais','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // dd($request);
            $this->validate($request, [
            'id_pegawai' =>'required',
            'id_role' =>'required',
            'username' => 'required|max:255|unique:user',
            'password' => 'required|min:6|confirmed'
        ]);

        //cek sudah terdaftar di SI ini belum
        $count_status=0;
        $cek_tabel_user= User::where('id_pegawai',$request->id_pegawai)->get();
        foreach ($cek_tabel_user as $cek) {
            $cek_tabel_user_si=TabelUserSi::where('id_user',$cek->id)->get();
            foreach ($cek_tabel_user_si as $key) {
                if($key->id_si==1){
                    flash('Pegawai ini telah terdaftar pada sistem')->important()->error();
                    return redirect()->route('userdata.create');
                    break;
                }
            }
        }

        //input ke table user ;
        $user = new User();
        $pegawai= Pegawai::find($request->id_pegawai)->first();
        $user->id_pegawai=$request->id_pegawai;
        $user->username=$request->username;
        $user->email=$pegawai->email;
        $user->password=bcrypt($request->password);
        $user->save();


        //input ke table user SI
        $tbl_user_si= new TabelUserSi;
        $id_user=User::orderBy('created_at','desc')->first();
        $tbl_user_si->id_user=$id_user->id;
        $tbl_user_si->id_si="1";
        $tbl_user_si->id_role=$request->id_role;
        $tbl_user_si->save();
        flash('Input user berhasil')->success();


        return redirect()->route('userdata.index');
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
        //yang diparsing di kontroller ini adalah id_user
        $user = User::find($id[0]);
        $pegawai = Pegawai::find($user->id_pegawai);
        $role = TabelUserSi::where('id_user',$id[0])->get();
        // dd($role);  

        return view('userdata.edit', compact('user','pegawai','role'));
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
        // dd($request);
            $this->validate($request, [
            'id_pegawai'=>'required',
            'username' => 'required|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required',
            'password' => 'required|min:6|confirmed',
            'gambar' => 'mimes:jpeg,bmp,jpg,png|max:5000'
        ]); 
        //update tabel user
        $user = User::findOrFail($id);
        $user->username=$request->username;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();

        //update tabel pegawai
        $pegawai = Pegawai::findOrFail($request->id_pegawai);
        $pegawai->email=$request->email;
        if(count($request->image)>0){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $request->file('image')->move("imageProfil/",$fileName);
            $pegawai->gambar = $fileName;
        }
        $pegawai->save();

        //update tabel user si
        $tbl_user_si = TabelUserSi::where('id_user',$id)->where('id_si','1')->first(); 
        $tbl_user_si->id_role=$request->role;
        $tbl_user_si->save();     
        
        flash('Edit user berhasil')->important()->success();
        return redirect()->route('userdata.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash('Delete user berhasil')->important()->success();
        return redirect()->route('userdata.index');
    }

}
