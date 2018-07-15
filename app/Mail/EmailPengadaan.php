<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailPengadaan extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        
        $user = $request->user;
        $nama_kegiatan=$request->nama_kegiatan;
        $tanggal_pengajuan=date('j F Y', strtotime($request->tanggal_pengajuan));
        $tanggal_kegiatan=date('j F Y', strtotime($request->tanggal_kegiatan));
        $tempat = $request->tempat;
        $waktu_mulai = $request->waktu_mulai;
        $waktu_selesai = $request->waktu_selesai;
        if($request->approvement=='1'){
        return $this->subject('Pengajuan Sarana dan Prasarana Biofarmaka')->markdown('emails.pengadaan.success')->with('user', $request->user)->with('tempat', $request->tempat)->with('waktu_mulai', $request->waktu_mulai)->with('waktu_selesai', $request->waktu_selesai)->with('nama_kegiatan', $request->nama_kegiatan)->with('tanggal_pengajuan', date('j F Y', strtotime($request->tanggal_pengajuan)))->with('tanggal_kegiatan', date('j F Y', strtotime($request->tanggal_kegiatan)));
        }
        elseif($request->approvement=='2'){
        return $this->subject('Pengajuan Sarana dan Prasarana Biofarmaka')->markdown('emails.pengadaan.failed')->with('user', $request->user)->with('tempat', $request->tempat)->with('waktu_mulai', $request->waktu_mulai)->with('waktu_selesai', $request->waktu_selesai)->with('nama_kegiatan', $request->nama_kegiatan)->with('tanggal_pengajuan', date('j F Y', strtotime($request->tanggal_pengajuan)))->with('tanggal_kegiatan', date('j F Y', strtotime($request->tanggal_kegiatan)));
        }
        else{
        return $this->subject('Pengajuan Sarana dan Prasarana Biofarmaka')->markdown('emails.pengadaan.warning')->with('user', $request->user)->with('tempat', $request->tempat)->with('waktu_mulai', $request->waktu_mulai)->with('waktu_selesai', $request->waktu_selesai)->with('nama_kegiatan', $request->nama_kegiatan)->with('tanggal_pengajuan', date('j F Y', strtotime($request->tanggal_pengajuan)))->with('tanggal_kegiatan', date('j F Y', strtotime($request->tanggal_kegiatan)));
        }
    }
}
