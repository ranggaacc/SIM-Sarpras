<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TabelRoleSi extends Model
{



   public $timestamps = true;
   public $table = "tbl_role_si";
   protected $primaryKey = 'id';
   protected $fillable=['id_si','id_role'];
   
   public function user()
   {
        return $this->belongsTo('App\Role','id');

   }

}
