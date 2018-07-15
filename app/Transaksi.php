<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Transaksi extends Model
{



   public $timestamps = false;
   public $table = "transaksi";
   protected $primaryKey = 'id';
   protected $fillable=['id_pegawai','keterangan','nominal','tanggal','status'];

}
