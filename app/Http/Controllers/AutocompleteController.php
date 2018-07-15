<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Codes;
use App\KodeBarang;
use App\Ruangan;
use Auth;
class AutocompleteController extends Controller
{
 
    public function autocomplete(Request $request)
    {

        $data = Codes::select("code as name")->where("code","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }
    public function dataAjax(Request $request)
    {
    	$data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("kode_barang")
            		->select("id","kode_barang", "nama_barang")
            		->where('kode_barang','LIKE',"%".$search."%")->orWhere('nama_barang','LIKE','%'.$search.'%')
            		->get();  
        }

        return response()->json($data);
    }
    public function dataAjax_ruangan(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("ruangan")
                    ->select("id","nama_ruang","kapasitas")
                    ->where('status_peminjaman','1')
                    ->where(function($query) use ($search){
                         $query->where('nama_ruang','LIKE',"%".$search."%")
                               ->orWhere('kode_ruang','LIKE','%'.$search.'%');
                           })
                    ->get();  
        }

        return response()->json($data);
    }
}
