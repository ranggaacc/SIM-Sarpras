<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KodeBarang extends Model
{
   protected $table = 'kode_barang';
   public $timestamps = false;
   protected $primaryKey = 'id';
   protected $fillable=['kode_barang','nama_barang'];

   public function Inventaris()
   {
        return $this->hasMany('App\Inventaris','id');

   }

   
}
