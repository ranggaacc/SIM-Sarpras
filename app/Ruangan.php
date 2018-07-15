<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
   public $timestamps = true;
   protected $table = "ruangan";
   protected $primaryKey = 'id';
   protected $fillable=['unit','bagian','gedung','nama_ruang','kode_ruang','wing','level','kapasitas','panjang','lebar','luas','lokasi','status_peminjaman','keterangan','gambar'];
   //1 dapat dipinjam 0 tidak
   // public function Peminjaman()
   // {
   //      return $this->belongsTo('App\User','id');

   // }
}
