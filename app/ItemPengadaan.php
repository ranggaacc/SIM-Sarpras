<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ItemPengadaan extends Model
{

   public $timestamps = false;
   public $table = "item_pengadaan";
   protected $primaryKey = 'id';
   protected $fillable=['form_id','unit','nama_barang','jenis','merk','jumlah','perkiraan','sub_total'];
   
   public function pengadaan()
   {
        return $this->belongsTo('App\User','id_item');

   }

}
