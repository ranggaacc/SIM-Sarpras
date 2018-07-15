<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UnitKerja extends Model
{



   public $timestamps = true;
   public $table = "unit_kerja";
   protected $primaryKey = 'id';
   protected $fillable=['nama'];
   
   public function user()
   {
        return $this->belongsTo('App\User','id');

   }

}
