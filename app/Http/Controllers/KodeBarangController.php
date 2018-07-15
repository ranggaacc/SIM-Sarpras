<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Facades\Datatables;
use Maatwebsite\Excel\Facades\Excel;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\User;
use App\KodeBarang;
use App\Pengadaan;
use App\UnitKerja;
use DB;
use Auth;
use Validator;
class KodeBarangController extends Controller {

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
        $users=Auth::user()->user_si;
        $get_data= KodeBarang::all();
        $count_data=count($get_data);

        return view('kodebarang.index',compact('count_data','get_data','users'));
    }

    public function readCell($column, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row == 1 || ($row >= 20 && $row <= 30)) {
            return true;
        }
        return false;
    }
    public function uploadcsv(Request $request){

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function data_kode(){      
       
        $codes = KodeBarang::select(['id','kode_barang','nama_barang']);
        return Datatables::of($codes)
        ->make(true);
    }
    public function create()
    {
        return view('kodebarang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    //     dd($request);
    // $rules = [
    //     'file' => 'required|mimes:.csv',
    // ];

    // $customMessages = [z
    //     'required' => 'File input is required',
    //     'mimes' => 'The file must be CSV.'
    // ];

    // $this->validate($request, $rules, $customMessages);
        $file = $request->file('file');
        // dd($file);
        $validator = Validator::make(
            [
                'file'      => $file,
                'extension' => strtolower($file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:csv,xlsx',
            ]
        );
        if ($validator->fails()) {
            return redirect('kodebarang/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadFilter( new MyReadFilter() );
        $spreadsheet = $reader->load($request->file);
        dd($spreadsheet);
        $this->readCell();
        


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
        $code = Codes::findOrFail($id);

        return view('kodebarang.edit', compact('code'));
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
            'code' => 'max:30',
        ]);

        $code =Codes::findOrFail($id);
        $code->code=$request->code;    
        $code->save();
        flash('Edit kode barang berhasil')->success();
        return redirect()->route('kodebarang.index');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $codes = Codes::findOrFail($id);
        $codes->delete();
        flash('Delete kode berhasil')->success();
        return redirect()->route('kodebarang.index');
    }

}
