<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\PeminjamanDisetujui;
use App\Mail\PeminjamanDitolak;
use Mail;

class ProcessMailPeminjaman implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public $tries = 5;
    protected $peminjam;
    protected $approvement;
    protected $peminjaman;
    public function __construct($peminjam,$approvement,$peminjaman)
    {
        $this->peminjam=$peminjam;
        $this->approvement=$approvement;
        $this->peminjaman=$peminjaman;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $peminjam=$this->peminjam;
        $peminjaman=$this->peminjaman;
        $approvement=$this->approvement;
        if($approvement=='1'){

            Mail::to($peminjam->email)->send(new PeminjamanDisetujui($peminjam,$peminjaman));
        }
        else 
        {
            Mail::to($peminjam->email)->send(new PeminjamanDitolak($peminjam,$peminjaman));
        }
    }
}
