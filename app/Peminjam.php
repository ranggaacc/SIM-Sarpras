<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
   public $timestamps = true;
   protected $table = "peminjam";
   protected $primaryKey = 'id';
   protected $fillable=['user_id','nama','jenis_kelamin','nomor_hp','telepon','gambar'];
   
   public function User()
   {
        return $this->belongsTo('App\User','id');

   }
}
