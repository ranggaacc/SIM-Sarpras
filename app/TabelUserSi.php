<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TabelUserSi extends Model
{



   public $timestamps = false;
   public $table = "tbl_user_si";
   protected $primaryKey = 'id';
   protected $fillable=['id_user','id_si','id_role'];
   
   public function user_si()
   {
        return $this->belongsTo('App\User','id');

   }
   
   public function role()
   {
        return $this->belongsTo('App\Role','id');

   }
}
