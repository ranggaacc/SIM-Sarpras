<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PeminjamanDisetujui extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($peminjam,$peminjaman)
    {
        $this->peminjam=$peminjam;
        $this->peminjaman=$peminjaman;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->subject('Pengajuan Peminjaman Ruangan Biofarmaka')->from("biofarmakaipb@gmail.com", "Administrator SIM-SARPRAS")->markdown('emails.peminjaman.success')->with('nama', $this->peminjam->nama)->with('tanggal_pengajuan',$this->peminjaman->tanggal_pengajuan)->with('keterangan', $this->peminjaman->keterangan);
        
    }
}
