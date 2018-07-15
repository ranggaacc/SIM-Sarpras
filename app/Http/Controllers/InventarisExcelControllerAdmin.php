<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Inventaris;
use App\UnitKerja;
use App\Pengadaan;
use App\KodeBarang;
use App\User;
use Auth;
class InventarisExcelControllerAdmin extends Controller
{
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

    public function excel($id) {
        
        // Execute the query used to retrieve the data. In this example
        // we're joining hypothetical users and payments tables, retrieving
        // the payments table's primary key, the user's first and last name, 
        // the user's e-mail address, the amount paid, and the payment
        // timestamp.()
        $get_unit= UnitKerja::where('nama',$id)->first();
        $unit=$get_unit->nama;
        $inventariss = Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->select('inventaris.id','kode_barang','inventaris.nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi')
        ->where(['id_unit'=>$get_unit->id])
        ->orderBy('tahun_barang','desc')
        ->get();
        // dd($inventariss);
        $count_data=count($inventariss);
        $count_data=$count_data+12;
        // Initialize the array which will be passed into the Excel
        // generator.
        // $inventarissArray = []; 
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
        Excel::create('DAFTAR INVENTARIS '.$unit, function($excel) use ($inventarissArray,$count_data,$unit){

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventaris '.$unit);
            $excel->setCreator('Laravel')->setCompany('Biofarmaka');
            $excel->setDescription('data inventaris');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($inventarissArray,$count_data,$unit) {

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
                $sheet->setBorder("A11:O$count_data", 'thin');
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


    public function excelSearch($id,Request $request) {

        // Execute the query used to retrieve the data. In this example
        // we're joining hypothetical users and payments tables, retrieving
        // the payments table's primary key, the user's first and last name, 
        // the user's e-mail address, the amount paid, and the payment
        // timestamp.
        
        //GET KEYWORD 
        $keyword=$request->q;
        $get_unit= UnitKerja::where('nama',$id)->first();
        $unit=$get_unit->nama;
        $inventariss = Inventaris::join('kode_barang', 'inventaris.id_kode_barang', '=', 'kode_barang.id')
        ->select('inventaris.id','kode_barang','inventaris.nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi')
        ->where(['id_unit'=>$get_unit->id])
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
