<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Pegawai extends Model
{



   public $timestamps = false;
   public $table = "pegawai";
   protected $primaryKey = 'id';
   protected $fillable=['id_unit','nama','nip','gelar_depan','gelar_belakang','no_ktp','tanggal_lahir','tempat_lahir','jabatan','jenis_kelamin','agama','status_kawin','gambar','email','nomor_hp','telepon','faks','alamat'];
   
   public function user()
   {
        return $this->belongsTo('App\User','id');

   }
   public function unit_kerja()
   {
        return $this->hasOne('App\UnitKerja','id','id_unit');
   } 
   public function role()
   {
        return $this->hasOne('App\Role','id');
   } 
   
}
