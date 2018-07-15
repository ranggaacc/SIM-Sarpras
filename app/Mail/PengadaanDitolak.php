<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PengadaanDitolak extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pegawai,$tanggal_pengajuan,$pengadaan)
    {
        $this->pegawai=$pegawai;
        $this->tanggal_pengajuan=$tanggal_pengajuan;
        $this->pengadaan=$pengadaan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->subject('Pengajuan Sarana dan Prasarana Biofarmaka')->from("biofarmakaipb@gmail.com", "Administrator SIM-SARPRAS")->markdown('emails.pengadaan.failed')->with('nama', $this->pegawai->nama)->with('tanggal_pengajuan',$this->tanggal_pengajuan)->with('keterangan', $this->pengadaan->keterangan);
        
    }
}
