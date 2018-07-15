<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Peminjaman;
use App\Peminjam;
use App\UnitKerja;
use Auth;
use Fpdf;
use Carbon\Carbon;
use DateTime;
// use Storage;

class LaporanPdfController extends Controller
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

    public function headerform($tanggalheader){
        $pdf = new Fpdf();
        $pdf::SetTitle('Penggunaan Ruangan'.' '.$tanggalheader);
        /*HEADER PDF*/
        $pdf::SetLineWidth(0.5);
        $pdf::SetFont('Arial','',10);
        $pdf::Cell(40,40,$pdf::Image(public_path().'/images/logoipb.png',15,15,30),1,'C');
        $pdf::Cell(70,30,'',1,'C');
        $pdf::SetFont('Arial','',12);
        $pdf::Cell(40,10,'Nomor Dokumen',1,'C');
        $pdf::SetFont('Arial','',10);
        $pdf::Cell(45,10,': F-RM/FASPRO-01/02/00',1,'C');

        $pdf::Ln();
        $pdf::SetFont('Arial','',12);    
        $pdf::Cell(110);
        $pdf::Cell(40,10,'Edisi/Revisi',1,'C');
        $pdf::Cell(45,10,': 2/0',1,'C');

        $pdf::Ln();
        $pdf::SetFont('Arial','B',12);    
        $pdf::Cell(40);
        $pdf::Cell(70,10,'',1,'C','B');
        $pdf::SetFont('Arial','',12);
        $pdf::Cell(40,10,'Tanggal',1,'C');
        $pdf::SetFont('Arial','',12);
        $pdf::Cell(45,10,': 3 Oktober 2016',1,'C');

        $pdf::Ln();
        $pdf::SetFont('Arial','',12);
        $pdf::Cell(40);
        $pdf::Cell(70,10,'',1,'C');
        $pdf::Cell(40,10,'Halaman',1,'C');
        $pdf::Cell(45,10,': 1',1,'C');

        $pdf::SetXY(50,10);
        $pdf::SetFont('Arial','',9);
        $pdf::Cell(70,10,'PUSAT STUDI BIOFARMAKA TROPIKA ',0,1,'C');
        $pdf::SetXY(50,20);
        $pdf::Cell(70,5,'LPPM-IPB',0,1,'C');

        $pdf::SetXY(50,30);
        $pdf::SetFont('Arial','B',12);    
        $pdf::Cell(70,10,'FORMULIR',0,1,'C');

        $pdf::SetXY(50,40);
        $pdf::SetFont('Arial','',12);
        $pdf::Cell(70,10,'PENGGUNAAN RUANGAN',0,1,'C');
       

    }

    public function footerform(){
        $pdf = new Fpdf();

        /*tanda tangan*/
        $pdf::Ln();
        $pdf::Ln();
        /*FOOTER*/
        $pdf::SetLineWidth(0.7);
        $pdf::Line(20,246,190,246);
        $pdf::SetLineWidth(0.1);
        $pdf::Line(20,247,190,247);
     

        $pdf::SetFont('Arial', '', 11);
        $pdf::Ln();
        $pdf::Ln();
        $pdf::Ln();
        
        $pdf::SetFont('Arial', 'B', 12);
        $pdf::cell(190,5,'PUSAT STUDI BIOFARMAKA TROPIKA LPPM-IPB',0,1,'C');
        $pdf::SetFont('Arial', '', 12);
        $pdf::cell(190,5,'Kampus IPB Taman Kencana, JL. Taman Kencana N0.3, Bogor 16128',0,1,'C');
        $pdf::cell(190,5,'Telp/Faks: 0251-8373561/0251-8347525; Email: bfarmaka@gmail.com; Website: ',0,1,'C');
        $pdf::cell(190,5,'http://biofarmaka.ipb.ac.id',0,1,'C');
    }

    public function headertable($tanggalheader){
            $pdf = new Fpdf();
            $pdf::SetLineWidth(0.1);
            $pdf::SetFont('Arial',null, 11);
            $pdf::Ln(5);
            $pdf::cell(8);
            //atribut ke 4 buat pake garis/border 0 tidak 1 ya
            $pdf::Cell(176, 30, "", 1, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::SetXY(10,57);
            $pdf::cell(8);
            $pdf::Cell(160, 4, "Bulan                  :       ".$tanggalheader, 0, 0, 'L', 0);

            $pdf::ln();
            $pdf::SetXY(104,55);
            $pdf::Cell(50, 30, "", 1, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::SetXY(102,55);
            $pdf::cell(8);
            $pdf::Cell(160, 6, "Penanggung Jawab", 0, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::SetXY(100,58);
            $pdf::cell(8);
            $pdf::Cell(162, 8, "Alat dan atau Ruangan", 0, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::SetXY(147,55);
            $pdf::cell(8);
            $pdf::Cell(160, 6, "PJ Bagian Fasilitas &", 0, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::SetXY(157,58);
            $pdf::cell(8);
            $pdf::Cell(162, 8, "Propery,", 0, 0, 'L', 0);

            $pdf::ln(4);
            $pdf::cell(8);
            /*HEADER TABEL*/
            $pdf::SetFont('Arial','B', 10);
            $pdf::Ln(5);
            $pdf::SetFillColor(204 , 204, 204);
            $pdf::cell(8);
            $pdf::SetXY(18,89);
            $pdf::Cell(10, 10, "NO", 1, 0, 'C', 1);
            $pdf::Cell(30, 10, 'TANGGAL', 1, 0, 'C', 1);
            $pdf::Cell(45, 10, 'NAMA RUANGAN', 1, 0, 'C', 1);
            $pdf::Cell(45, 10, 'NAMA PEMINJAM', 1, 0, 'C', 1);
            $pdf::Cell(45, 10, 'KETERANGAN*', 1, 0, 'C', 1);
            //set font untuk data
            $pdf::SetFont('Arial',null, 8);


    }    
    public function generatepdf(Request $request){
        // dd($request->laporan);
       
        $parse= DateTime::createFromFormat('m/Y', $request->laporan);

        //parse tanggal laporan
        $tahun=$parse->format('Y');
        $bulan=$parse->format('m');

        $tanggalheader=$parse->format('M Y');
        // $tahun=strtotime(date('M'$request->laporan));
        $get_data =Peminjaman::whereYear( 'waktu_mulai', '=', $tahun )
                    ->where( function ($query) use ($bulan)
                    {
                        $query->whereMonth( 'waktu_mulai',$bulan)
                        ->where('status','=','1');
                    })
                    ->join('peminjam','peminjaman.id_user','peminjam.user_id')
                    ->join('ruangan','peminjaman.id_ruangan','=','ruangan.id')
                    ->select('waktu_mulai','nama','nama_ruang','waktu_mulai','peminjaman.keterangan')
                    ->get();
        $count_data=count($get_data);
        $titlefile='Penggunaan Ruangan '.date('j F Y', strtotime($tanggalheader));
        $total=0;
        foreach ($get_data as $key) {
            $total+=$key->sub_total;
        }
        $pathfile='';
        $pdf = new Fpdf();
        $pdf::AddPage();

       
         if($count_data<=23){

        /*header*/
            $this->headerform($tanggalheader);
        /*header table*/
            $this->headertable($tanggalheader);

        /*body*/

            /*KALAU DATA <= 10 */
            $i=1;
            $i2=$count_data+1;

            foreach($get_data as $data){
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::Cell(10, 5, '   '.$i++, 1, 0, 'L', 0);
            $pdf::SetFont('Arial','', 7);
            $pdf::Cell(30, 5, date("d F Y", strtotime($data->waktu_mulai)), 1, 0, 'C', 0);
            $pdf::Cell(45, 5, substr ( $data->nama_ruang, 0,26), 1, 0, 'L', 0);
            $pdf::Cell(45, 5, substr ( $data->nama, 0,26), 1, 0, 'L', 0);
            $pdf::Cell(45, 5, substr ( $data->keterangan, 0,35), 1, 0, 'L', 0);
            }

            for($i2;$i2<=23;$i2++){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::SetFont('Arial','', 7);
                $pdf::Cell(10, 5, '   '.$i2, 1, 0, 'L', 0);
                $pdf::Cell(30, 5, '', 1, 0, 'L', 0);
                $pdf::Cell(45, 5, '', 1, 0, 'L', 0);
                $pdf::Cell(45, 5, '', 1, 0, 'L', 0);
                $pdf::Cell(45, 5, '', 1, 0, 'L', 0);
            }
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::SetFont('Arial','', 8);
            $pdf::Cell(140, 8, '*: Sekretariat, UPT, Divisi, Proyek', 0, 0, 'L', 0);
            /*footer*/
            $this->footerform();
        }
         else{

        /*PAGE 1*/
        /*header*/
            $this->headerform($tanggalheader);
        /*header table*/
            $this->headertable($tanggalheader);

        /*body*/
            $i=1;
            $i2=$count_data+1;
            $get_data_page1 =Peminjaman::whereYear( 'waktu_mulai', '=', $tahun )
                    ->where( function ($query) use ($bulan)
                    {
                        $query->whereMonth( 'waktu_mulai',$bulan)
                        ->where('status','=','1');
                    })
                    ->join('peminjam','peminjaman.id_user','peminjam.user_id')
                    ->join('ruangan','peminjaman.id_ruangan','=','ruangan.id')
                    ->select('waktu_mulai','nama','nama_ruang','waktu_mulai','peminjaman.keterangan')
                    ->skip(0)->take(23)
                    ->get();

            foreach($get_data_page1 as $data){
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::Cell(10, 5, '   '.$i++, 1, 0, 'L', 0);
            $pdf::SetFont('Arial','', 7);
            $pdf::Cell(30, 5, date("d F Y", strtotime($data->waktu_mulai)), 1, 0, 'C', 0);
            $pdf::Cell(45, 5, substr ( $data->nama_ruang, 0,26), 1, 0, 'L', 0);
            $pdf::Cell(45, 5, substr ( $data->nama, 0,26), 1, 0, 'L', 0);
            $pdf::Cell(45, 5, substr ( $data->keterangan, 0,35), 1, 0, 'L', 0);
            }

            for($i2;$i2<=23;$i2++){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::SetFont('Arial','', 7);
                $pdf::Cell(10, 5, '   '.$i2, 1, 0, 'L', 0);
                $pdf::Cell(30, 5, '', 1, 0, 'L', 0);
                $pdf::Cell(45, 5, '', 1, 0, 'L', 0);
                $pdf::Cell(45, 5, '', 1, 0, 'L', 0);
                $pdf::Cell(45, 5, '', 1, 0, 'L', 0);
            }
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::SetFont('Arial','', 8);
            $pdf::Cell(140, 8, '*: Sekretariat, UPT, Divisi, Proyek', 0, 0, 'L', 0);

            /*footer*/
            $this->footerform();


            /*PAGE 2 */
            $pdf::AddPage();
            /*header*/
            $this->headerform($tanggalheader);
            /*header table*/
            $this->headertable($tanggalheader);


            $get_data_page2 =Peminjaman::whereYear( 'waktu_mulai', '=', $tahun )
                    ->where( function ($query) use ($bulan)
                    {
                        $query->whereMonth( 'waktu_mulai',$bulan)
                        ->where('status','=','1');
                    })
                    ->join('peminjam','peminjaman.id_user','peminjam.user_id')
                    ->join('ruangan','peminjaman.id_ruangan','=','ruangan.id')
                    ->select('waktu_mulai','nama','nama_ruang','waktu_mulai','peminjaman.keterangan')
                    ->skip(23)->take(23)
                    ->get();
            $count_data2=count($get_data_page2);
            $i2=1;
            $i3=$count_data2+1;

            foreach($get_data_page2 as $data){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::Cell(10, 5, '   '.$i2++, 1, 0, 'L', 0);
                $pdf::SetFont('Arial','', 7);
                $pdf::Cell(30, 5, date("d F Y", strtotime($data->waktu_mulai)), 1, 0, 'C', 0);
                $pdf::Cell(45, 5, substr ( $data->nama_ruang, 0,26), 1, 0, 'L', 0);
                $pdf::Cell(45, 5, substr ( $data->nama, 0,26), 1, 0, 'L', 0);
                $pdf::Cell(45, 5, substr ( $data->keterangan, 0,35), 1, 0, 'L', 0);
            }

            for($i3;$i3<=23;$i3++){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::SetFont('Arial','', 7);
                $pdf::Cell(10, 5, '   '.$i3, 1, 0, 'L', 0);
                $pdf::Cell(30, 5, '', 1, 0, 'L', 0);
                $pdf::Cell(45, 5, '', 1, 0, 'L', 0);
                $pdf::Cell(45, 5, '', 1, 0, 'L', 0);
                $pdf::Cell(45, 5, '', 1, 0, 'L', 0);
            }
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::SetFont('Arial','', 8);
            $pdf::Cell(140, 8, '*: Sekretariat, UPT, Divisi, Proyek', 0, 0, 'L', 0);

            
            /*footer*/
             $this->footerform();
         }
        
        $pdf::Output('D',$titlefile.'.pdf');
        // $pdf::Output('D',$titlefile.'.pdf');
      exit;
    }

 }

