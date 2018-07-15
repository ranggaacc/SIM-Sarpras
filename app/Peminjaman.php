<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
   public $timestamps = false;
   protected $table = "peminjaman";
   protected $primaryKey = 'id';
   protected $fillable=['id_user','id_ruangan','status','waktu_mulai','waktu_selesai','keterangan','tanggal_pengajuan','file1','file2'];
   
   public function users()  
   {
        return $this->belongsTo('App\User','id');

   }

   public function ruangan()  
   {
        return $this->belongsTo('App\Ruangan','id_ruangan');

   }
}
