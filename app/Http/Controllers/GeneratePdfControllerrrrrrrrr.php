<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\ItemPengadaan;
use App\Pengadaan;
use App\UnitKerja;
use Auth;
use Fpdf;
// use Storage;

class GeneratePdfController extends Controller
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

    public function headerform($id){
        $get_form=Pengadaan::where('id_form',$id)->get();
        $get_tanggal=date('j F Y', strtotime($get_form[0]->tanggal_pengajuan));
        $pdf = new Fpdf();
        $pdf::SetTitle('Pengajuan ItemPengadaan sarpras tanggal'.' '.$get_tanggal);
        /*HEADER PDF*/
        $pdf::SetLineWidth(0.5);
        $pdf::SetFont('Arial','',10);
        $pdf::Cell(40,40,$pdf::Image(public_path().'/images/logoipb.png',15,15,30),1,'C');
        $pdf::Cell(70,30,'',1,'C');
        $pdf::SetFont('Arial','',12);
        $pdf::Cell(40,10,'Nomor Dokumen',1,'C');
        $pdf::Cell(45,10,': F-RM/ADM-06/02/00',1,'C');

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
        $pdf::Cell(45,10,': 6',1,'C');

        $pdf::SetXY(50,10);
        $pdf::SetFont('Arial','',10);
        $pdf::Cell(70,10,'PUSAT STUDI BIOFARMAKA TROPIKA ',0,1,'C');
        $pdf::SetXY(50,20);
        $pdf::Cell(70,5,'LPPM-IPB',0,1,'C');

        $pdf::SetXY(50,30);
        $pdf::SetFont('Arial','B',12);    
        $pdf::Cell(70,10,'FORMULIR',0,1,'C');

        $pdf::SetXY(50,40);
        $pdf::SetFont('Arial','',12);
        $pdf::Cell(70,10,'PENGAJUAN DANA',0,1,'C');

        /*body*/

        $pdf::SetLineWidth(0.1);
        $pdf::SetFont('Arial',null, 11);
        $pdf::Ln(10);
        $pdf::cell(8);
        $pdf::Cell(176, 30, "", 1, 0, 'L', 0);

        $pdf::Ln();
        $pdf::SetXY(10,60);
        $pdf::cell(8);
        $pdf::Cell(160, 6, "Nama Kegiatan              :".' '.$get_form[0]->nama_kegiatan, 0, 0, 'L', 0);

        $pdf::Ln();
        $pdf::cell(8);
        $pdf::Cell(160, 6, "Hari/Tanggal Kegiatan   :".' '.$get_form[0]->tanggal_kegiatan, 0, 0, 'L', 0);

        $pdf::Ln();
        $pdf::cell(8);
        $pdf::Cell(160, 6, "Waktu                             :".' '.$get_form[0]->waktu_mulai."-".$get_form[0]->waktu_selesai, 0, 0, 'L', 0);

        $pdf::Ln();
        $pdf::cell(8);
        $pdf::Cell(160, 6, "Tempat                           :".' '.$get_form[0]->tempat, 0, 0, 'L', 0);

        $pdf::Ln();
        $pdf::cell(8);
        $pdf::Cell(160, 6, "Tanggal Pengajuan        :".' '.$get_form[0]->tanggal_pengajuan, 0, 0, 'L', 0);
       

    }

    public function footerform($id){
        $get_form=Pengadaan::where('id_form',$id)->get();
        $get_tanggal=date('j F Y', strtotime($get_form[0]->tanggal_pengajuan));
        $pdf = new Fpdf();
        $pdf::Ln();
        $pdf::cell(8);
        $pdf::SetFont('Arial','B', 11);
        $pdf::Cell(10, 8, "", 1, 0, 'L', 0);
        $pdf::Cell(138, 8, 'TOTAL', 1, 0, 'L', 0);
        $pdf::Cell(28, 8, '', 1, 0, 'C', 0);


        /*tanda tangan*/
        $pdf::Ln();
        $pdf::SetFont('Arial',null, 11);
        $pdf::Ln();
        $pdf::cell(17);
        $pdf::Cell(65, 6, "Pemohon,", 0, 0, 'L', 0);
        $pdf::Cell(65, 6, "Menyetujui,", 0, 0, 'L', 0);
        $pdf::Cell(65, 6, "Mengetahui,", 0, 0, 'L', 0);


        $pdf::Ln();
        $pdf::Ln();
        $pdf::Ln();
        $pdf::Ln();
        $pdf::Ln();
        $pdf::cell(5);
        $pdf::Cell(65, 6, '( ...................................... ) ', 0, 0, 'L', 0);
        $pdf::Cell(65, 6, '( ...................................... ) ', 0, 0, 'L', 0);
        $pdf::Cell(65, 6, '( ...................................... ) ', 0, 0, 'L', 0);



        /*FOOTER*/
        $pdf::SetLineWidth(0.7);
        $pdf::Line(20,246,190,246);
        $pdf::SetLineWidth(0.1);
        $pdf::Line(20,247,190,247);
     

        $pdf::SetFont('Arial', '', 11);
        $pdf::Ln();
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
    
    public function generatepdf($id){
        dd($id);
        $get_form=Pengadaan::where('id',$id)->first();
        $get_kegiatan=$get_form->nama_kegiatan;
        $get_data =ItemPengadaan::where('form_id',$id)->get();
        $get_tanggal=date('j F Y', strtotime($get_form[0]->tanggal_pengajuan));
        $count_data=count($get_data);
        $titlefile='Sarpras Untuk Kegiatan'.' '.$get_kegiatan.' '.$get_tanggal;
        $pathfile='';
        $pdf = new Fpdf();
        $pdf::AddPage();

       
        if($count_data<=10){
            /*header*/
            $this->headerform($id);

            /*DATA*/
            $pdf::SetFont('Arial','B', 11);
            $pdf::Ln(10);
            $pdf::cell(8);
            $pdf::Cell(10, 10, "NO", 1, 0, 'C', 0);
            $pdf::Cell(65, 10, 'KETERANGAN ', 1, 0, 'C', 0);
            $pdf::Cell(15, 10, 'JMLH ', 1, 0, 'C', 0);
            $pdf::Cell(18, 10, 'UNIT ', 1, 0, 'C', 0);
            $pdf::Cell(40, 10, 'PERKIRAAN BIAYA ', 1, 0, 'C', 0);
            $pdf::Cell(28, 10, 'SUB TOTAL ', 1, 0, 'C', 0);
            $pdf::SetFont('Arial',null, 11);


            /*KALAU DATA <= 10 */
            $i=1;
            $i2=$count_data+1;

            foreach($get_data as $data){
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::Cell(10, 8, '   '.$i++, 1, 0, 'L', 0);
            $pdf::Cell(65, 8, $data->keterangan, 1, 0, 'C', 0);
            $pdf::Cell(15, 8, $data->jumlah, 1, 0, 'C', 0);
            $pdf::Cell(18, 8, $data->unit, 1, 0, 'C', 0);
            $pdf::Cell(40, 8, $data->perkiraan, 1, 0, 'C', 0);
            $pdf::Cell(28, 8, $data->sub_total, 1, 0, 'C', 0);
            }

            for($i2;$i2<=10;$i2++){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::Cell(10, 8, '   '.$i2, 1, 0, 'L', 0);
                $pdf::Cell(65, 8, '', 1, 0, 'C', 0);
                $pdf::Cell(15, 8, '', 1, 0, 'C', 0);
                $pdf::Cell(18, 8, '', 1, 0, 'C', 0);
                $pdf::Cell(40, 8, '', 1, 0, 'C', 0);
                $pdf::Cell(28, 8, '', 1, 0, 'C', 0);
            }
            /*footer*/
            $this->footerform($id);
        }
        else{

            /*PAGE 1*/

            /*header*/
            $this->headerform($id);

            /*DATA*/
            $pdf::SetFont('Arial','B', 11);
            $pdf::Ln(10);
            $pdf::cell(8);
            $pdf::Cell(10, 10, "NO", 1, 0, 'C', 0);
            $pdf::Cell(65, 10, 'KETERANGAN ', 1, 0, 'C', 0);
            $pdf::Cell(15, 10, 'JMLH ', 1, 0, 'C', 0);
            $pdf::Cell(18, 10, 'UNIT ', 1, 0, 'C', 0);
            $pdf::Cell(40, 10, 'PERKIRAAN BIAYA ', 1, 0, 'C', 0);
            $pdf::Cell(28, 10, 'SUB TOTAL ', 1, 0, 'C', 0);
            $pdf::SetFont('Arial',null, 11);


            /*TABEL DATA*/
            $i=1;
            $i2=$count_data+1;
            $get_data_page1 = ItemPengadaan::where('form_id',$id)->skip(0)->take(10)->orderBy('id_item')->get();
            foreach($get_data_page1 as $data){
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::Cell(10, 8, '   '.$i++, 1, 0, 'L', 0);
            $pdf::Cell(65, 8, $data->keterangan, 1, 0, 'C', 0);
            $pdf::Cell(15, 8, $data->jumlah, 1, 0, 'C', 0);
            $pdf::Cell(18, 8, $data->unit, 1, 0, 'C', 0);
            $pdf::Cell(40, 8, $data->perkiraan, 1, 0, 'C', 0);
            $pdf::Cell(28, 8, $data->sub_total, 1, 0, 'C', 0);
            }
            /*footer*/
            $this->footerform($id);
            

            /*PAGE 2 */
            $pdf::AddPage();
            /*header*/
            $this->headerform($id);
            
            
            $get_data_page2 = ItemPengadaan::where('form_id',$id)->skip(10)->take(10)->orderBy('id_item')->get();
            $count_data2=count($get_data_page2);
            $i2=1;
            $i3=$count_data2+1;

            /*DATA*/
            $pdf::SetFont('Arial','B', 11);
            $pdf::Ln(10);
            $pdf::cell(8);
            $pdf::Cell(10, 10, "NO", 1, 0, 'C', 0);
            $pdf::Cell(65, 10, 'KETERANGAN ', 1, 0, 'C', 0);
            $pdf::Cell(15, 10, 'JMLH ', 1, 0, 'C', 0);
            $pdf::Cell(18, 10, 'UNIT ', 1, 0, 'C', 0);
            $pdf::Cell(40, 10, 'PERKIRAAN BIAYA ', 1, 0, 'C', 0);
            $pdf::Cell(28, 10, 'SUB TOTAL ', 1, 0, 'C', 0);
            $pdf::SetFont('Arial',null, 11);

            /*TABEL DATA*/

            foreach($get_data_page2 as $data){
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::Cell(10, 8, '   '.$i2++, 1, 0, 'L', 0);
            $pdf::Cell(65, 8, $data->keterangan, 1, 0, 'C', 0);
            $pdf::Cell(15, 8, $data->jumlah, 1, 0, 'C', 0);
            $pdf::Cell(18, 8, $data->uni2t, 1, 0, 'C', 0);
            $pdf::Cell(40, 8, $data->perki2raan, 1, 0, 'C', 0);
            $pdf::Cell(28, 8, $data->sub_total, 1, 0, 'C', 0);
            }
            for($i3;$i3<=10;$i3++){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::Cell(10, 8, '   '.$i3, 1, 0, 'L', 0);
                $pdf::Cell(65, 8, '', 1, 0, 'C', 0);
                $pdf::Cell(15, 8, '', 1, 0, 'C', 0);
                $pdf::Cell(18, 8, '', 1, 0, 'C', 0);
                $pdf::Cell(40, 8, '', 1, 0, 'C', 0);
                $pdf::Cell(28, 8, '', 1, 0, 'C', 0);
            }
            
            /*footer*/
            $this->footerform($id);
        }
        

        $pdf::Output('D',$titlefile.'.pdf');
      exit;
    }

 }

