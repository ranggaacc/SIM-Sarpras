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
use Auth;
use Hashids;
use Validator;


class SekretariatController extends Controller
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
        $this->middleware('roles:1');

    }  
    public function index()
    {

        $inventariss= Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->select('inventaris.id','kode_barang','inventaris.nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi','gambar')
        ->where(function($query){
            $query->where('id_unit','10')
            ->where('deleted_at',null);
        })        
        ->get();

        $inventaris_trashed= Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->select('inventaris.id','kode_barang','inventaris.nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi','gambar')
        ->where(function($query){
            $query->where('id_unit','10');
        })    
        ->onlyTrashed()
        ->get();
        // dd($inventaris_trashed);
        return view('admin.index',compact('inventariss','unit','inventaris_trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data= KodeBarang::all();
        $lokasi= Ruangan::all();
        return view('admin.create',compact('data','lokasi'));
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
            'B'=> 'max:10',
            'RR'=> 'max:10',
            'RB'=> 'max:10',
            'ket'=> 'max:300',
            'lokasi'=> 'required|max:30',
            'image'=> 'mimes:jpeg,bmp,png',
        ]);

        $input= new Inventaris;
        $input->id_unit='10';
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
        return redirect()->route('sekretariat.index');
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
        return view('admin.edit',['inventaris' => $inventaris,'kode_barang'=>$kode_barang,'unit'=>$unit,'lokasi'=>$lokasi,'lokasi_sekarang'=>$lokasi_sekarang]);
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
            'B'=> 'max:4',
            'RR'=> 'max:4',
            'RB'=> 'max:4',
            'ket'=> 'max:300',
            'lokasi'=> 'required|max:30',
            'image'=> 'mimes:jpeg,bmp,png',
        ]);


        $input = Inventaris::findOrFail($id);
        $input->id_unit='10';

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
        return redirect()->route('sekretariat.index');     
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
     public function excel() {

            // Execute the query used to retrieve the data. In this example
            // we're joining hypothetical users and payments tables, retrieving
            // the payments table's primary key, the user's first and last name, 
            // the user's e-mail address, the amount paid, and the payment
            // timestamp.
            $id_unit= Auth::user()->pegawai->id_unit;
            $get_unit=UnitKerja::select('nama')->where('nama','sekret')->first();
            $unit=$get_unit->nama;
            $inventariss = Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
            ->select('inventaris.id','kode_barang','inventaris.nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi')
            ->where('id_unit','10')
            ->orderBy('tahun_barang','desc')
            ->get();
            $count=count($inventariss);
            // dd($inventariss);

            // Initialize the array which will be passed into the Excel
            // generator.
            // $inventarissArray = []; 

            // // Define the Excel spreadsheet headers
            // $inventarissArray[] = ['kode_barang','nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','ket','lokasi'];

            // Convert each member of the returned collection into an array,
            // and append it to the payments array.

            if($inventariss->count()>0){
                    foreach ($inventariss as $inventaris) {
                        $inventarissArray[] = $inventaris->toArray();
                    }
                    /*LOOP KOLOM NO DI EXCEL*/
                    for ($i=0; $i <count($inventarissArray); $i++) { 
                        $inventarissArray[$i]['id']=$i+1;
                    }
                    // Generate and return the spreadsheet
                    // Generate and return the spreadsheet
                    Excel::create('DAFTAR INVENTARIS '.$unit, function($excel) use ($inventarissArray,$unit,$count) {

                        // Set the spreadsheet title, creator, and description
                        $excel->setTitle('Inventaris '.$unit);
                        $excel->setCreator('Laravel')->setCompany('Biofarmaka');
                        $excel->setDescription('data inventaris');

                        // Build the spreadsheet, passing in the payments array
                        $excel->sheet('sheet1', function($sheet) use ($inventarissArray,$unit,$count) {
                            $count+=12;
                            $sheet->fromArray($inventarissArray, null, 'A13', false, false);
                            $sheet->mergeCells('A1:C1');
                            $sheet->mergeCells('A2:C2');
                            $sheet->mergeCells('A5:B5');
                            $sheet->mergeCells('A6:B6');
                            $sheet->mergeCells('A7:B7');
                            $sheet->mergeCells('A8:B8');
                            $sheet->mergeCells('A9:B9');
                            $sheet->row(1,['KEMENTRIAN RISET TEKNOLOGI DAN PENDIDIKAN TINGGI']);
                            $sheet->row(2,['INSTITUT PERTANIAN BOGOR']);
                            $sheet->row(4,['','','DAFTAR INVENTARIS BARANG']);
                            $sheet->row(5,['UNIT KERJA (FAK/DIR/KANTOR/PUSAT)       ','',': PUSAT STUDI BIOFARMAKA LPPM IPB']);
                            $sheet->row(6,['DEPARTEMEN/JURUSAN                      ','',': ']);
                            $sheet->row(7,['NAMA RUANG                              ','',': ']);
                            $sheet->row(8,['KODE RUANG                              ','',': ']);
                            $sheet->row(9,['GEDUNG/WING/LEVEL                       ','',': Kampus IPB Taman Kencana']);
                            $sheet->row(11,['NO','KODE BARANG','NAMA BARANG','MERK/TYPE','TAHUN PEMBUATAN / PEMBELIAN','HARGA SATUAN (Rp.)','JUMLAH BARANG','SATUAN','JUMLAH HARGA (Rp.)','SUMBER DANA','KONDISI BARANG','','','KET.','LOKASI'])->mergeCells('A11:A12')->mergeCells('B11:B12')->mergeCells('C11:C12')->mergeCells('D11:D12')->mergeCells('E11:E12')->mergeCells('F11:F12')->mergeCells('G11:G12')->mergeCells('H11:H12')->mergeCells('I11:I12')->mergeCells('J11:J12')->mergeCells('K11:M11')->mergeCells('M11:M12')->mergeCells('N11:N12')->mergeCells('O11:O12');
                            $sheet->row(12,['','','','','','','','','','','B','RR','RB','']);


                            $sheet->cell('A5:B9', function($cell) {
                                $cell->setAlignment('left');
                                $cell->setFont(array(
                                    'size'       => '10',
                                    'bold'       =>  true
                                ));
                                $cell->setFontFamily('Arial');
                            });

                            $sheet->cell('A1:C3', function($cell) {
                                $cell->setAlignment('left');
                                $cell->setFont(array(
                                    'size'       => '10',
                                    'bold'       =>  true
                                ));
                                $cell->setFontFamily('Arial');
                            });
                            $sheet->cell('C2:C9', function($cell) {
                                $cell->setAlignment('left');
                                $cell->setFont(array(
                                    'size'       => '10',
                                    'bold'       =>  true
                                ));
                                $cell->setFontFamily('Arial');
                            });
                            $sheet->setWidth(array(
                                        'A'     =>  3,
                                        'B'     =>  25,
                                        'C'     =>  25,
                                        'D'     =>  18,
                                        'E'     =>  18,
                                        'F'     =>  18,
                                        'G'     =>  13,
                                        'H'     =>  13,
                                        'I'     =>  18,
                                        'J'     =>  18,
                                        'K'     =>  6,
                                        'L'     =>  6,
                                        'M'     =>  6,     
                                        'N'     =>  18,
                                        'O'     =>  8,
                                    ));
                            /*BOLD HEADER*/
                            $sheet->cell('A11:O11', function($cell) {
                                $cell->setAlignment('center');
                                $cell->setFont(array(
                                    'size'       => '10',
                                    'bold'       =>  true
                                ));
                                $cell->setValignment('center');
                                $cell->setFontFamily('Arial');
                            });
                            /*wrap text header*/
                            $sheet->getStyle('D11:J11')->getAlignment()->setWrapText(true);

                            /*MERGE B RR RB*/
                            $sheet->cell('K12:M12', function($cell) {
                                $cell->setAlignment('center');
                                $cell->setFont(array(
                                    'size'       => '10',
                                    'bold'       =>  true
                                ));
                                $cell->setValignment('center');
                                $cell->setFontFamily('Arial');
                            });
                            /*tulisan daftar inventaris barang*/
                            $sheet->cell('C4', function($cell) {
                                $cell->setAlignment('left');
                                $cell->setFont(array(
                                    'size'       => '12',
                                    'bold'       =>  true
                                ));
                                $cell->setFontFamily('Arial');
                            });
                            /*TITLE*/
                            $sheet->setTitle($unit);
                            /*BORDER*/
                            $sheet->setBorder("A11:O$count", 'thin');
                            /*DATA*/
                            $sheet->cell('A13:O0', function($cell) {
                                $cell->setAlignment('center');
                                $cell->setFont(array(
                                    'size'       => '10',
                                    'bold'       =>  false,
                                    'font'       =>'Arial'
                                ));
                                $cell->setValignment('center');
                                $cell->setFontFamily('Arial');
                            });
                            $sheet->cell('C13:C40', function($cell) {
                                $cell->setAlignment('left');
                            });
                                            
                        });

                    })->download('xls');  
            } return redirect()->back();  
        }


        public function excelSearch(Request $request) {

            // Execute the query used to retrieve the data. In this example
            // we're joining hypothetical users and payments tables, retrieving
            // the payments table's primary key, the user's first and last name, 
            // the user's e-mail address, the amount paid, and the payment
            // timestamp.
            
            //GET KEYWORD
            $keyword=$request->q;
            $id_unit= Auth::user()->pegawai->id_unit;
            $get_unit=UnitKerja::select('nama')->where('nama','sekret')->first();
            $unit=$get_unit->nama;
            $inventariss = Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
            ->select('inventaris.id','kode_barang','inventaris.nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi')
            ->where('id_unit','10')
            ->where(function($query) use ($keyword){
                $query->where('tahun_barang','LIKE','%'.$keyword.'%')
                      ->orWhere('lokasi','LIKE','%'.$keyword.'%');
                })
            ->orderBy('tahun_barang','desc')
            ->get();
            $count=count($inventariss);

            // Initialize the array which will be passed into the Excel
            // generator.
            // Convert each member of the returned collection into an array,
            // and append it to the payments array.
            if($inventariss->count()>0){
            foreach ($inventariss as $inventaris) {
                $inventarissArray[] = $inventaris->toArray();
            }
            /*LOOP KOLOM NO DI EXCEL*/
            for ($i=0; $i <count($inventarissArray); $i++) { 
                $inventarissArray[$i]['id']=$i+1;
            }
           Excel::create('DAFTAR INVENTARIS '.$unit, function($excel) use ($inventarissArray,$unit,$count) {

                // Set the spreadsheet title, creator, and description
                $excel->setTitle('Inventaris '.$unit);
                $excel->setCreator('Laravel')->setCompany('Biofarmaka');
                $excel->setDescription('data inventaris');

                // Build the spreadsheet, passing in the payments array
                $excel->sheet('sheet1', function($sheet) use ($inventarissArray,$unit,$count) {
                    $count+=12;
                    $sheet->fromArray($inventarissArray, null, 'A13', false, false);
                    $sheet->mergeCells('A1:C1');
                    $sheet->mergeCells('A2:C2');
                    $sheet->mergeCells('A5:B5');
                    $sheet->mergeCells('A6:B6');
                    $sheet->mergeCells('A7:B7');
                    $sheet->mergeCells('A8:B8');
                    $sheet->mergeCells('A9:B9');
                    $sheet->row(1,['KEMENTRIAN RISET TEKNOLOGI DAN PENDIDIKAN TINGGI']);
                    $sheet->row(2,['INSTITUT PERTANIAN BOGOR']);
                    $sheet->row(4,['','','DAFTAR INVENTARIS BARANG']);
                    $sheet->row(5,['UNIT KERJA (FAK/DIR/KANTOR/PUSAT)       ','',': PUSAT STUDI BIOFARMAKA LPPM IPB']);
                    $sheet->row(6,['DEPARTEMEN/JURUSAN                      ','',': ']);
                    $sheet->row(7,['NAMA RUANG                              ','',': ']);
                    $sheet->row(8,['KODE RUANG                              ','',': ']);
                    $sheet->row(9,['GEDUNG/WING/LEVEL                       ','',': Kampus IPB Taman Kencana']);
                    $sheet->row(11,['NO','KODE BARANG','NAMA BARANG','MERK/TYPE','TAHUN PEMBUATAN / PEMBELIAN','HARGA SATUAN (Rp.)','JUMLAH BARANG','SATUAN','JUMLAH HARGA (Rp.)','SUMBER DANA','KONDISI BARANG','','','KET.','LOKASI'])->mergeCells('A11:A12')->mergeCells('B11:B12')->mergeCells('C11:C12')->mergeCells('D11:D12')->mergeCells('E11:E12')->mergeCells('F11:F12')->mergeCells('G11:G12')->mergeCells('H11:H12')->mergeCells('I11:I12')->mergeCells('J11:J12')->mergeCells('K11:M11')->mergeCells('M11:M12')->mergeCells('N11:N12')->mergeCells('O11:O12');
                    $sheet->row(12,['','','','','','','','','','','B','RR','RB','']);


                    $sheet->cell('A5:B9', function($cell) {
                        $cell->setAlignment('left');
                        $cell->setFont(array(
                            'size'       => '10',
                            'bold'       =>  true
                        ));
                        $cell->setFontFamily('Arial');
                    });

                    $sheet->cell('A1:C3', function($cell) {
                        $cell->setAlignment('left');
                        $cell->setFont(array(
                            'size'       => '10',
                            'bold'       =>  true
                        ));
                        $cell->setFontFamily('Arial');
                    });
                    $sheet->cell('C2:C9', function($cell) {
                        $cell->setAlignment('left');
                        $cell->setFont(array(
                            'size'       => '10',
                            'bold'       =>  true
                        ));
                        $cell->setFontFamily('Arial');
                    });
                    $sheet->setWidth(array(
                                'A'     =>  3,
                                'B'     =>  25,
                                'C'     =>  25,
                                'D'     =>  18,
                                'E'     =>  18,
                                'F'     =>  18,
                                'G'     =>  13,
                                'H'     =>  13,
                                'I'     =>  18,
                                'J'     =>  18,
                                'K'     =>  6,
                                'L'     =>  6,
                                'M'     =>  6,     
                                'N'     =>  18,
                                'O'     =>  8,
                            ));
                    /*BOLD HEADER*/
                    $sheet->cell('A11:O11', function($cell) {
                        $cell->setAlignment('center');
                        $cell->setFont(array(
                            'size'       => '10',
                            'bold'       =>  true
                        ));
                        $cell->setValignment('center');
                        $cell->setFontFamily('Arial');
                    });
                    /*wrap text header*/
                    $sheet->getStyle('D11:J11')->getAlignment()->setWrapText(true);

                    /*MERGE B RR RB*/
                    $sheet->cell('K12:M12', function($cell) {
                        $cell->setAlignment('center');
                        $cell->setFont(array(
                            'size'       => '10',
                            'bold'       =>  true
                        ));
                        $cell->setValignment('center');
                        $cell->setFontFamily('Arial');
                    });
                    /*tulisan daftar inventaris barang*/
                    $sheet->cell('C4', function($cell) {
                        $cell->setAlignment('left');
                        $cell->setFont(array(
                            'size'       => '12',
                            'bold'       =>  true
                        ));
                        $cell->setFontFamily('Arial');
                    });
                    /*TITLE*/
                    $sheet->setTitle($unit);
                    /*BORDER*/
                    $sheet->setBorder("A11:O$count", 'thin');
                    /*DATA*/
                    $sheet->cell('A13:O40', function($cell) {
                        $cell->setAlignment('center');
                        $cell->setFont(array(
                            'size'       => '10',
                            'bold'       =>  false,
                            'font'       =>'Arial'
                        ));
                        $cell->setValignment('center');
                        $cell->setFontFamily('Arial');
                    });
                    $sheet->cell('C13:C40', function($cell) {
                        $cell->setAlignment('left');
                    });
                                    
                });

            })->download('xls');
            }
            return redirect()->back();
            
        }
    
}
