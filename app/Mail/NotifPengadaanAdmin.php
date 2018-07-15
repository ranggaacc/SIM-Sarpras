<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;
class NotifPengadaanAdmin extends Mailable
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
        
        return $this->subject('Pengajuan Pengadaan Barang Biofarmaka')->from("biofarmakaipb@gmail.com", "SIM-SARPRAS")->markdown('emails.pengadaan.notif_pengadaan')->with(['url' => URL::to('/login')]);
        
    }
}
