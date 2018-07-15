<?php
use App\Inventarises;
use Illuminate\Support\Facades\Input;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get("/gue_logout","UserController@help_logout");
Route::post('/addPeminjam','PeminjamController@addPeminjam');
Route::group(['middleware' => 'auth'], function(){
  Route::get('pageAksesKhusus', function () {
      return view('pageAksesKhusus');
  });
  Route::get("/kode-data","KodeBarangController@data_kode");
  Route::get("/user-data","UserDataController@data_user");
  Route::get('/','UserController@index');
  Route::get('autocomplete',array('as'=>'autocomplete','uses'=>'AutocompleteController@autocomplete'));//using form input
  Route::get('autocomplete2',array('as'=>'autocomplete2','uses'=>'AutocompleteController@dataAjax'));//using select
  Route::get('autocomplete_ruangan',array('as'=>'autocomplete_ruangan','uses'=>'AutocompleteController@dataAjax_ruangan'));
  Route::get('/editprofil/{id}','EditProfilController@editprofil');
  Route::get('/editprofilpeminjam/{id}','EditProfilController@editprofilpeminjam');
  Route::post('/postprofilpeminjam/{id}','EditProfilController@postprofilpeminjam');
  Route::post('/postprofil/{id}','EditProfilController@postprofil');
  Route::post('/postprofil/update/{id}',[
    'uses'=>'EditProfilController@postprofil',
    'as'=>'update.profil']);
  Route::post('/postprofilpeminjam/update/{id}',[
    'uses'=>'EditProfilController@postprofilpeminjam',
    'as'=>'updatepeminjam.profil']);
  Route::resource('user','UserController');
  Route::get('/panel/{id}','UserController@panel');
  Route::resource('home','UserController');
  Route::resource('kodebarang','KodeBarangController');
  Route::get('/editkode/{id}','KodeBarangController@edit');
  Route::resource('kodebarang', 'KodeBarangController', ['parameters' => [
      'id' => 'id'
  ]]);

  /*ROUTE MIDDLE MIDDLE MANAGEMENT*/
  Route::resource('inventaris','InventarisController');
  Route::resource('pengadaan','PengadaanController');
  Route::resource('inventaris', 'InventarisController', ['parameters' => [
      'id' => 'id_inventaris'
  ]]);
  Route::get('/inventarisDelete/{id}','InventarisController@destroy');
  Route::get('/inventarisDeletePermanent/{id}','InventarisController@force_destroy');
  Route::get('/inventarisDeletePermanentAll','InventarisController@force_destroy_all');
  Route::get('/restore_id/{id}','InventarisController@restore_id');
  Route::get('/restore_all','InventarisController@restore_all');
  Route::get('/pengadaandelete/{id}','PengadaanController@destroy');
  Route::get('/itempengadaandelete/{id}','PengadaanController@destroy_item');
  Route::get('/generatepdf/{id}','GeneratePdfController@generatepdf');
  // Route::resource('tabelInventaris', 'TabelInventarisController', ['parameters' => [
  //     'id' => 'roles'
  // ]]);
  Route::get('/excel','InventarisExcelController@excel'); 
  Route::get('/excelSearch','InventarisExcelController@excelSearch');
  Route::get('/image/{id}', function ($id) {
      return view('middle.image', ['id'=>$id]);
  });
  Route::post('/importExcel','InventarisController@importExcel');

  /*ROUTE ADMINISTRATOR*/
  Route::get('/TabelInventarisAdmin/{id}','TabelInventarisAdminController@show');
  Route::get('/excelAdmin/{id}', 'InventarisExcelControllerAdmin@excel');
  Route::get('/excelSearchAdmin/{id}','InventarisExcelControllerAdmin@excelSearch');
  Route::get('/excelAdminAll/','InventarisExcelControllerAdmin@excelAll');
  Route::get('/userdelete/{id}','UserDataController@destroy');
  Route::get('/sarprasall','SarprasAllUnitController@index');
  Route::get('/sarprasall/excelAll','SarprasAllUnitController@excelAll');
  Route::get('/sarprasall/search','SarprasAllUnitController@excelSearch');
  Route::get('/pengadaanadmindelete/{id}','PengadaanAdminController@destroy');
  Route::get('/ruangandelete/{id}','RuanganController@destroy');
  
  Route::get('/excelSekretariat','SekretariatController@excel');
  Route::get('/excelSearchSekretariat','SekretariatController@excelSearch');
  Route::get('/peminjamanadmindelete/{id}','PeminjamanAdminController@destroy');
  Route::get('/sekretariatDelete/{id}','SekretariatController@destroy');
  Route::get('/sekretariatDeletePermanent/{id}','SekretariatController@force_destroy');
  Route::get('/sekretariatDeletePermanentAll','SekretariatController@force_destroy_all');
  Route::get('/sekretariat_restore_id/{id}','SekretariatController@restore_id');
  Route::get('/sekretariat_restore_all','SekretariatController@restore_all'); 
  Route::post('/approvement/{id}','PengadaanAdminController@approvement');
  Route::post('/approvementpeminjaman/{id}','PeminjamanAdminController@approvement');
  Route::post('/laporan','LaporanPdfController@generatepdf');
  Route::post('/importExcelAdmin','SekretariatController@importExcel');
  Route::resource('userdata','UserDataController');
  Route::resource('pengadaanadmin','PengadaanAdminController');
  Route::resource('ruangan','RuanganController');
  Route::resource('peminjamanadmin','PeminjamanAdminController');
  Route::resource('sekretariat','SekretariatController');

  /*ROUTE EXECUTIVE*/
  Route::get('/exe/{id}','ExecutiveController@show');
  Route::get('/jenis/{id}','ExecutiveController@jenis');
  Route::get('/panel2/{id}','ExecutiveController@panel2');
  Route::get('/panel3/{id}','ExecutiveController@panel3');
  Route::get('/panel4/{id}','ExecutiveController@panel4');
  /*PEMINJAMAN*/
  // Route::get('/peminjaman/peminjaman_index','PeminjamanController@peminjaman_index');
  Route::get('/peminjamandelete/{id}','PeminjamanController@destroy');
  Route::resource('peminjaman','PeminjamanController');

});
