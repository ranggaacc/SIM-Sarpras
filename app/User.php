<?php namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // public $table = "users";
    protected $table = 'user';
    protected $fillable = [
        'id_pegawai','username' , 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
   public function hasInventaris()
   {
        return $this->hasMany('App\Inventarises','roles_id');

   }
   
   public function pegawai()  
   {
        return $this->belongsTo('App\Pegawai','id_pegawai');

   }
   public function peminjam()  
   {
        return $this->hasOne('App\Peminjam','user_id');

   }
   public function role_si()
   {
        return $this->hasOne('App\TabelRoleSi','id');

   }
   public function user_si()
   {
        return $this->hasMany('App\TabelUserSi','id_user');

   }
   // public function unit_kerja()
   // {
   //      return $this->hasOne('App\UnitKerja','id');
   // } 
   //roles unit uih,ukhp,uppw,lpsb,ukbb
    public function punyaRole($roles){
        $users= Auth::user()->user_si;
        foreach ( $users as $key) {        
          if($key->id_si==1 && $key->id_role==$roles){
            return true;
            break;
          }
          return false;
        }
         //buat cek apa bener dia pake role user atau bukan, keluaran true atau false

        
    }
}
