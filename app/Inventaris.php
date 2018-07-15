<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventaris extends Model
{
   use SoftDeletes;


   public $timestamps = true;
   public $table = "inventaris";
   protected $dates = ['deleted_at'];
   protected $primaryKey = 'id';
   protected $fillable=['unit','fk_id_barang','nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi','gambar'];
   
   public function inventaris()
   {
        return $this->belongsTo('App\User','id');

   }

   public function nama_barang()
   {
        return $this->belongsTo('App\KodeBarang','id_kode_barang');

   }

}
