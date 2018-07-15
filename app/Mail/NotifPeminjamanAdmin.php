<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;
class NotifPeminjamanAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $invoice = url('http://localhost:8000/upload/file/Contoh File.xlsx');
        return $this->subject('Pengajuan Peminjaman Ruangan Biofarmaka')->from("biofarmakaipb@gmail.com", "SIM-SARPRAS")->markdown('emails.peminjaman.notif_peminjaman')->with(['url' => URL::to('/login')]);
        
    }
}
