<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
   public $timestamps = true;
   public $table = "pengadaan";
   protected $primaryKey = 'id';
   protected $fillable=['id_pegawai','id_transaksi','approvement','tanggal_pengajuan','unit','item','keterangan','nominal_type'];
}
