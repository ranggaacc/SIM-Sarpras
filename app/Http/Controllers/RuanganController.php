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
use App\Ruangan;
use DB;
use Auth;
use Hashids;
use Validator;

class RuanganController extends Controller {

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
        $ruangans= Ruangan::all();
        return view('ruangan.index',compact('ruangans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return view('ruangan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */

    public function store(Request $request)
    {

        $this->validate($request, [
            'unit'=> 'required|max:100',
            'bagian'=> 'required|max:20',
            'gedung'=> 'required|max:20',
            'nama_ruang'=> 'required|max:20',
            'kode_ruang'=> 'required|max:20',
            'wing'=> 'max:5',
            'level'=> 'max:20',
            'kapasitas'=> 'required|max:20',
            'panjang'=> 'required|max:10',
            'lebar'=> 'required|max:10',
            'luas'=> 'required',
            'keterangan'=> 'max:300',
            'lokasi'=> 'required|max:30',
            'peminjaman' => 'required',
            'image'=> 'mimes:jpeg,bmp,png',
        ]);
            $input= new Ruangan;
            $input->unit=$request->unit;
            $input->bagian=$request->bagian;
            $input->gedung=$request->gedung;
            $input->nama_ruang=$request->nama_ruang;
            $input->kode_ruang=$request->kode_ruang;
            $input->wing=$request->wing;
            $input->level=$request->level;
            $input->kapasitas=$request->kapasitas;
            $input->panjang=$request->panjang;
            $input->lebar=$request->lebar;
            $input->luas=$request->luas;
            $input->keterangan=$request->keterangan;
            $input->lokasi=$request->lokasi;
            $input->status_peminjaman=$request->peminjaman;
            if(count($request->image)>0){
                $file = $request->file('image');
                $fileName = $file->getClientOriginalName();
                $request->file('image')->move("imageRuangan/",$fileName);
                $input->gambar = $fileName;
            }
            $input->save();
            flash('Input ruangan berhasil')->important()->success();
            return redirect()->route('ruangan.index');
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
        if($id==[]){
            return redirect()->back();
        }
        else  
     
        $ruangan=Ruangan::findOrFail($id[0]);
        return view('ruangan.edit', compact('ruangan'));
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
            'unit'=> 'required|max:100',
            'bagian'=> 'required|max:100',
            'gedung'=> 'required|max:100',
            'nama_ruang'=> 'required|max:100',
            'kode_ruang'=> 'required|max:100',
            'wing'=> 'max:5',
            'level'=> 'max:100',
            'kapasitas'=> 'required|max:100',
            'panjang'=> 'max:10',
            'lebar'=> 'max:10',
            'luas'=> 'max:10',
            'keterangan'=> 'max:300',
            'lokasi'=> 'required|max:30',
            'peminjaman'=> 'required',
            'image'=> 'mimes:jpeg,bmp,png',
        ]);
            $input = Ruangan::findOrFail($id);
            $input->unit=$request->unit;
            $input->bagian=$request->bagian;
            $input->gedung=$request->gedung;
            $input->nama_ruang=$request->nama_ruang;
            $input->kode_ruang=$request->kode_ruang;
            $input->wing=$request->wing;
            $input->level=$request->level;
            $input->kapasitas=$request->kapasitas;
            $input->panjang=$request->panjang;
            $input->lebar=$request->lebar;
            $input->luas=$request->luas;
            $input->keterangan=$request->keterangan;
            $input->status_peminjaman=$request->peminjaman;
            $input->lokasi=$request->lokasi;
            if(count($request->image)>0){
                $file = $request->file('image');
                $fileName = $file->getClientOriginalName();
                $request->file('image')->move("imageRuangan/",$fileName);
                $input->gambar = $fileName;
            }
            $input->save();
            flash('Edit ruangan berhasil')->important()->success();
            return redirect()->route('ruangan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();
        flash('Delete ruangan berhasil')->important()->success();
        return redirect()->route('ruangan.index');
    }

}
