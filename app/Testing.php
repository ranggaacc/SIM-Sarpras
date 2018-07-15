<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Testing extends Model
{



   public $timestamps = true;
   public $table = "testing";
   protected $dates = ['deleted_at'];
   protected $primaryKey = 'id';
   protected $fillable=['unit','fk_id_barang','nama_barang','merk_barang','tahun_barang','harga_satuan','jumlah_barang','satuan','jumlah_harga','sumber_dana','B','RR','RB','keterangan','lokasi','gambar'];
  

}
