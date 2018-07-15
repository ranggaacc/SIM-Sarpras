<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\PengadaanDisetujui;
use App\Mail\PengadaanDitolak;
use Mail;

class ProcessMailPengadaan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public $tries = 5;
    protected $pegawai;
    protected $tanggal_pengajuan;
    protected $approvement;
    protected $pengadaan;
    public function __construct($pegawai,$tanggal_pengajuan,$approvement,$pengadaan)
    {
        $this->pegawai=$pegawai;
        $this->tanggal_pengajuan=$tanggal_pengajuan;
        $this->approvement=$approvement;
        $this->pengadaan=$pengadaan;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pegawai=$this->pegawai;
        $tanggal_pengajuan=$this->tanggal_pengajuan;
        $approvement=$this->approvement;
        $pengadaan=$this->pengadaan;


        if($approvement=='1'){

            Mail::to($pegawai->email)->send(new PengadaanDisetujui($pegawai,$tanggal_pengajuan,$pengadaan));
            // Mail::raw('Dear Bapak/Ibu. '.$pegawai->nama.',

            // Pengajuan pengadaan anda pada tanggal'.': '. date('j F Y', strtotime($this->tanggal_pengajuan)).'
            // untuk keperluan "'.$pengadaan->keterangan.'"
            
            // telah disetujui

            // Untuk detail lebih lanjut silahkan datang ke frontdesk Biofarmaka.               
            // Pusat Studi Biofarmaka Tropika IPB (TROP BRC)
            // SIM-SARPRAS', function($message) use ($pegawai)
            // {
            //     $message->from("biofarmakaipb@gmail.com", "Administrator SIM-SARPRAS");
            //     $message->to($pegawai->email);           
            //     $message->subject("--Pengajuan Pengadaan Sarpras--");
            //     // $message->markdown('emails.pengadaan.success');
            //     //$message->attach(asset($layanan->file_skdu), ["as" => "skdu.pdf", "mime" => "pdf"]);
            // });
        }
        else 
        {
            Mail::to($pegawai->email)->send(new PengadaanDitolak($pegawai,$tanggal_pengajuan,$pengadaan));
            // Mail::raw('Dear Bapak/Ibu. '.$pegawai->nama.',

            // Pengajuan pengadaan anda pada tanggal'.': '. date('j F Y', strtotime($this->tanggal_pengajuan)).'
            // untuk keperluan "'.$pengadaan->keterangan.'"
            
            // ditolak

            // Untuk detail lebih lanjut silahkan datang ke frontdesk Biofarmaka.               
            // Pusat Studi Biofarmaka Tropika IPB (TROP BRC)
            // SIM-SARPRAS', function($message) use ($pegawai)
            // {
            //     $message->from("biofarmakaipb@gmail.com", "Administrator SIM-SARPRAS");
            //     $message->to($pegawai->email);           
            //     $message->subject("--Pengajuan Pengadaan Sarpras--");
            //     // $message->markdown('emails.pengadaan.success');
            //     //$message->attach(asset($layanan->file_skdu), ["as" => "skdu.pdf", "mime" => "pdf"]);
            // });
        }
    }
}
