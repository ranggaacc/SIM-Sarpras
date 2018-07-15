<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codes extends Model
{
   protected $tabel='codes';
   public $timestamps = false;
   protected $primaryKey = 'id';
   protected $fillable=['code'];
   
}
