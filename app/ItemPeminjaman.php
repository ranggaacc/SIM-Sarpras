<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ItemPeminjaman extends Model
{

   public $timestamps = false;
   public $table = "item_peminjaman";
   protected $primaryKey = 'id';
   protected $fillable=['form_id','tanggal_mulai','tanggal_selesai','id_ruangan','keterangan'];
   


}
