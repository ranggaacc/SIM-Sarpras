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
        $get_form=Pengadaan::where('id',$id)->first();
        $get_tanggal=date('j F Y', strtotime($get_form->tanggal_pengajuan));
        $pdf = new Fpdf();
        $pdf::SetTitle('Pengajuan ItemPengadaan sarpras tanggal'.' '.$get_tanggal);
        /*HEADER PDF*/
        $pdf::SetLineWidth(0.5);
        $pdf::SetFont('Arial','',10);
        $pdf::Cell(40,40,$pdf::Image(public_path().'/images/logoipb.png',15,15,30),1,'C');
        $pdf::Cell(70,30,'',1,'C');
        $pdf::SetFont('Arial','',12);
        $pdf::Cell(40,10,'Nomor Dokumen',1,'C');
        $pdf::SetFont('Arial','',10);
        $pdf::Cell(45,10,': F-RM/FASPRO-05/02/00',1,'C');

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
        $pdf::Cell(45,10,': 5',1,'C');

        $pdf::SetXY(50,10);
        $pdf::SetFont('Arial','',9);
        $pdf::Cell(70,10,'PUSAT STUDI BIOFARMAKA TROPIKA ',0,1,'C');
        $pdf::SetXY(50,20);
        $pdf::Cell(70,5,'LPPM-IPB',0,1,'C');

        $pdf::SetXY(50,30);
        $pdf::SetFont('Arial','B',12);    
        $pdf::Cell(70,10,'FORMULIR',0,1,'C');

        $pdf::SetXY(50,40);
        $pdf::SetFont('Arial','',10);
        $pdf::Cell(70,10,'PERMOHONAN PENGADAAN BARANG',0,1,'C');

        // $pdf::Cell(160, 6, "Tanggal Pengajuan        :".' 3 Oktober 2016 ', 0, 0, 'L', 0);
       

    }

    public function footerform($id){
        $get_form=Pengadaan::where('id',$id)->first();
        $get_tanggal=date('j F Y', strtotime($get_form->tanggal_pengajuan));
        $pdf = new Fpdf();

        /*tanda tangan*/
        $pdf::Ln();
        $pdf::SetFont('Arial',null, 11);
        $pdf::Ln();
        $pdf::cell(17);
        $pdf::Cell(62, 6, "Yang mengajukan,", 0, 0, 'L', 0);
        $pdf::Cell(65, 6, "Menyetujui,", 0, 0, 'L', 0);
        $pdf::Cell(65, 6, "Mengetahui,", 0, 0, 'L', 0);
        $pdf::ln();
        $pdf::cell(18);
        $pdf::Cell(42, 6, "Airlangga Peminjam", 0, 0, 'L', 0);
        $pdf::Cell(68, 6, "PJ Bagian Fasilitas & Properti", 0, 0, 'L', 0);
        $pdf::Cell(100, 6, "Kepala Pusat Studi Biofarmaka", 0, 0, 'L', 0);
        $pdf::ln();
        $pdf::cell(19);
        $pdf::Cell(48, 6, "       ", 0, 0, 'L', 0);
        $pdf::Cell(85, 6, "                   ", 0, 0, 'L', 0);
        $pdf::Cell(100, 6, "Tropika", 0, 0, 'L', 0);

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
        
        $pdf::SetFont('Arial', 'B', 12);
        $pdf::cell(190,5,'PUSAT STUDI BIOFARMAKA TROPIKA LPPM-IPB',0,1,'C');
        $pdf::SetFont('Arial', '', 12);
        $pdf::cell(190,5,'Kampus IPB Taman Kencana, JL. Taman Kencana N0.3, Bogor 16128',0,1,'C');
        $pdf::cell(190,5,'Telp/Faks: 0251-8373561/0251-8347525; Email: bfarmaka@gmail.com; Website: ',0,1,'C');
        $pdf::cell(190,5,'http://biofarmaka.ipb.ac.id',0,1,'C');

        //ttd pj faspro       
        $pdf::cell(18);
        $pdf::SetXY(50,40);
        $pdf::Cell(20,5,$pdf::Image(public_path().'/images/ttd.jpg',92,220,30),0,'C');
        //ttd kepala pusat
        $pdf::ln();
        $pdf::Cell(190,5,$pdf::Image(public_path().'/images/ttd.jpg',155,220,30),0,'C');



    }

    public function headertable($get_form){
            $pdf = new Fpdf();
            $pdf::SetLineWidth(0.1);
            $pdf::SetFont('Arial',null, 11);
            $pdf::Ln(5);
            $pdf::cell(8);
            //atribut ke 4 buat pake garis/border 0 tidak 1 ya
            $pdf::Cell(176, 30, "", 0, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::SetXY(10,60);
            $pdf::cell(8);
            $pdf::Cell(160, 6, "Kepada ", 0, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::cell(8);
            $pdf::Cell(160, 6, "            Yth PJ Bagian Fasilitas & Properti,", 0, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::cell(8);
            $pdf::Cell(160, 6, "            Pusat Studi Biofarmaka Tropika LPPM-IPB", 0, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::cell(8);
            $pdf::Cell(162, 8, "Yang Mengajukan           :".' '.$get_form->pengaju, 0, 0, 'L', 0);

            $pdf::ln(5);
            $pdf::cell(8);
            $pdf::Cell(162, 8, "Tanggal                           :".' '.date('d-m-Y', strtotime($get_form->tanggal_pengajuan)), 0, 0, 'L', 0);

            $pdf::ln(4);
            $pdf::cell(8);
            /*HEADER TABEL*/
            $pdf::SetFont('Arial','B', 10);
            $pdf::Ln(5);
            $pdf::SetFillColor(204 , 204, 204);
            $pdf::cell(8);
            $pdf::Cell(10, 10, "NO", 1, 0, 'C', 1);
            $pdf::SetXY(28,89);
            $pdf::Cell(43, 10, 'NAMA ALAT/BAHAN', 1, 0, 'C', 1);
            $pdf::Cell(23, 10, 'JENIS', 1, 0, 'C', 1);
            $pdf::Cell(18, 10, 'MERK', 1, 0, 'C', 1);
            $pdf::Cell(18, 10, 'JUMLAH', 1, 0, 'C', 1);
            $pdf::Cell(38, 10, 'PERKIRAAN (Rp)', 1, 0, 'C', 1);
            $pdf::Cell(31, 10, 'SUB TOTAL (Rp)', 1, 0, 'C', 1);
            //set font untuk data
            $pdf::SetFont('Arial',null, 8);


    }    
    public function generatepdf($id){
        $get_form=Pengadaan::where('id',$id)->first();
        $get_data =ItemPengadaan::where('form_id',$id)->get();
        $count_data=count($get_data);
        $titlefile='Pengajuan Sarana dan Prasarana tanggal '.date('j F Y', strtotime($get_form->tanggal_pengajuan));
        $total=0;
        foreach ($get_data as $key) {
            $total+=$key->sub_total;
        }
        $pathfile='';
       


            $get_data_page=0;
            $get_data_page1 = ItemPengadaan::where('form_id',$id)->skip(0)->take(10)->orderBy('id')->get();
            $count_data_page1=count($get_data_page1);
            $get_data_page2 = ItemPengadaan::where('form_id',$id)->skip(10)->take(10)->orderBy('id')->get();
            $count_data_page2=count($get_data_page2);
            $get_data_page3 = ItemPengadaan::where('form_id',$id)->skip(20)->take(10)->orderBy('id')->get();
            $count_data_page3=count($get_data_page3);
            $get_data_page4 = ItemPengadaan::where('form_id',$id)->skip(30)->take(10)->orderBy('id')->get();
            $count_data_page4=count($get_data_page4);

         if($count_data_page1!=null){
            $pdf = new Fpdf();
            $pdf::AddPage();
        /*header*/
            $this->headerform($id);
        /*header table*/
            $this->headertable($get_form);
        /*body*/
            /*KALAU DATA <= 10 */
            $i=1;
            $i1=$count_data_page1+1;

            foreach($get_data_page1 as $data){
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::Cell(10, 8, '   '.$i++, 1, 0, 'L', 0);
            $pdf::Cell(43, 8, substr ( $data->nama_barang, 0,22), 1, 0, 'L', 0);
            $pdf::Cell(23, 8, substr ( $data->jenis, 0,15), 1, 0, 'L', 0);
            $pdf::Cell(18, 8, substr ( $data->merk, 0,12), 1, 0, 'L', 0);
            $pdf::Cell(18, 8, $data->jumlah, 1, 0, 'L', 0);
            $pdf::Cell(38, 8, $data->perkiraan, 1, 0, 'L', 0);
            $pdf::Cell(31, 8, $data->sub_total, 1, 0, 'L', 0);
            }

            for($i1;$i1<=10;$i1++){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::Cell(10, 8, '   '.$i1, 1, 0, 'L', 0);
                $pdf::Cell(43, 8, '', 1, 0, 'L', 0);
                $pdf::Cell(23, 8, '', 1, 0, 'L', 0);
                $pdf::Cell(18, 8, '', 1, 0, 'L', 0);
                $pdf::Cell(18, 8, '', 1, 0, 'L', 0);
                $pdf::Cell(38, 8, '', 1, 0, 'L', 0);
                $pdf::Cell(31, 8, '', 1, 0, 'L', 0);
            }
            $pdf::Ln();
            $pdf::cell(8);
            $pdf::SetFont('Arial','B', 11);
            $pdf::Cell(10, 8, "", 1, 0, 'L', 0);
            $pdf::Cell(140, 8, 'TOTAL', 1, 0, 'L', 0);
            $pdf::SetFont('Arial','', 8);
            if($count_data_page2!=null)
                $pdf::Cell(31, 8,'Rp.'.' '.number_format(0 , 2 , ',' , '.' ), 1, 0, 'L', 0);
            else
                $pdf::Cell(31, 8,'Rp.'.' '.number_format($total , 2 , ',' , '.' ), 1, 0, 'L', 0);
            /*footer*/
            $this->footerform($id);
        }
        if($count_data_page2!=null){
                $pdf::AddPage();
            /*header*/
                $this->headerform($id);
            /*header table*/
                $this->headertable($get_form);
            /*body*/
                /*KALAU DATA <= 10 */
                $i=1;
                $i2=$count_data_page2+1;

                foreach($get_data_page2 as $data){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::Cell(10, 8, '   '.$i++, 1, 0, 'L', 0);
                $pdf::Cell(43, 8, substr ( $data->nama_barang, 0,22), 1, 0, 'L', 0);
                $pdf::Cell(23, 8, substr ( $data->jenis, 0,15), 1, 0, 'L', 0);
                $pdf::Cell(18, 8, substr ( $data->merk, 0,12), 1, 0, 'L', 0);
                $pdf::Cell(18, 8, $data->jumlah, 1, 0, 'L', 0);
                $pdf::Cell(38, 8, $data->perkiraan, 1, 0, 'L', 0);
                $pdf::Cell(31, 8, $data->sub_total, 1, 0, 'L', 0);
                }

                for($i2;$i2<=10;$i2++){
                    $pdf::Ln();
                    $pdf::cell(8);
                    $pdf::Cell(10, 8, '   '.$i2, 1, 0, 'L', 0);
                    $pdf::Cell(43, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(23, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(18, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(18, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(38, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(31, 8, '', 1, 0, 'L', 0);
                }
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::SetFont('Arial','B', 11);
                $pdf::Cell(10, 8, "", 1, 0, 'L', 0);
                $pdf::Cell(140, 8, 'TOTAL', 1, 0, 'L', 0);
                $pdf::SetFont('Arial','', 8);
                if($count_data_page3!=null)
                    $pdf::Cell(31, 8,'Rp.'.' '.number_format(0 , 2 , ',' , '.' ), 1, 0, 'L', 0);
                else
                    $pdf::Cell(31, 8,'Rp.'.' '.number_format($total , 2 , ',' , '.' ), 1, 0, 'L', 0);
                /*footer*/
                $this->footerform($id);
        }
        if($count_data_page3!=null){
                $pdf::AddPage();
            /*header*/
                $this->headerform($id);
            /*header table*/
                $this->headertable($get_form);
            /*body*/
                /*KALAU DATA <= 10 */
                $i=1;
                $i3=$count_data_page3+1;

                foreach($get_data_page3 as $data){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::Cell(10, 8, '   '.$i++, 1, 0, 'L', 0);
                $pdf::Cell(43, 8, substr ( $data->nama_barang, 0,22), 1, 0, 'L', 0);
                $pdf::Cell(23, 8, substr ( $data->jenis, 0,15), 1, 0, 'L', 0);
                $pdf::Cell(18, 8, substr ( $data->merk, 0,12), 1, 0, 'L', 0);
                $pdf::Cell(18, 8, $data->jumlah, 1, 0, 'L', 0);
                $pdf::Cell(38, 8, $data->perkiraan, 1, 0, 'L', 0);
                $pdf::Cell(31, 8, $data->sub_total, 1, 0, 'L', 0);
                }

                for($i3;$i3<=10;$i3++){
                    $pdf::Ln();
                    $pdf::cell(8);
                    $pdf::Cell(10, 8, '   '.$i3, 1, 0, 'L', 0);
                    $pdf::Cell(43, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(23, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(18, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(18, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(38, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(31, 8, '', 1, 0, 'L', 0);
                }
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::SetFont('Arial','B', 11);
                $pdf::Cell(10, 8, "", 1, 0, 'L', 0);
                $pdf::Cell(140, 8, 'TOTAL', 1, 0, 'L', 0);
                $pdf::SetFont('Arial','', 8);
                if($count_data_page4!=null)
                    $pdf::Cell(31, 8,'Rp.'.' '.number_format(0 , 2 , ',' , '.' ), 1, 0, 'L', 0);
                else
                    $pdf::Cell(31, 8,'Rp.'.' '.number_format($total , 2 , ',' , '.' ), 1, 0, 'L', 0);
                /*footer*/
                $this->footerform($id);
            }
        if($count_data_page4!=null){
                $pdf::AddPage();
            /*header*/
                $this->headerform($id);
            /*header table*/
                $this->headertable($get_form);
            /*body*/
                /*KALAU DATA <= 10 */
                $i=1;
                $i4=$count_data_page4+1;

                foreach($get_data_page4 as $data){
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::Cell(10, 8, '   '.$i++, 1, 0, 'L', 0);
                $pdf::Cell(43, 8, substr ( $data->nama_barang, 0,22), 1, 0, 'L', 0);
                $pdf::Cell(23, 8, substr ( $data->jenis, 0,15), 1, 0, 'L', 0);
                $pdf::Cell(18, 8, substr ( $data->merk, 0,12), 1, 0, 'L', 0);
                $pdf::Cell(18, 8, $data->jumlah, 1, 0, 'L', 0);
                $pdf::Cell(38, 8, $data->perkiraan, 1, 0, 'L', 0);
                $pdf::Cell(31, 8, $data->sub_total, 1, 0, 'L', 0);
                }

                for($i4;$i4<=10;$i4++){
                    $pdf::Ln();
                    $pdf::cell(8);
                    $pdf::Cell(10, 8, '   '.$i4, 1, 0, 'L', 0);
                    $pdf::Cell(43, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(23, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(18, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(18, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(38, 8, '', 1, 0, 'L', 0);
                    $pdf::Cell(31, 8, '', 1, 0, 'L', 0);
                }
                $pdf::Ln();
                $pdf::cell(8);
                $pdf::SetFont('Arial','B', 11);
                $pdf::Cell(10, 8, "", 1, 0, 'L', 0);
                $pdf::Cell(140, 8, 'TOTAL', 1, 0, 'L', 0);
                $pdf::SetFont('Arial','', 8);
                $pdf::Cell(31, 8,'Rp.'.' '.number_format($total , 2 , ',' , '.' ), 1, 0, 'L', 0);
                /*footer*/
                $this->footerform($id);
        }     
        // $pdf::Output();
        $pdf::Output('D',$titlefile.'.pdf');
      exit;
    }

 }

