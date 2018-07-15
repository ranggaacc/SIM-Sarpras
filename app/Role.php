<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Role extends Model
{



   public $timestamps = true;
   public $table = "role";
   protected $primaryKey = 'id';
   protected $fillable=['nama_role','keterangan'];
   
   public function user()
   {
        return $this->belongsTo('App\User','id');

   }

}
