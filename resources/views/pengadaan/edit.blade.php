@extends('layouts/master')
@section('title','Daftar Sarana & Prasarana')
@section('content')
<link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" />
<script>
function toggle() {
 if( document.getElementById("hidethis").style.display=='none' ){
   document.getElementById("hidethis").style.display = 'table-row'; // set to table-row instead of an empty string
 }else{
   document.getElementById("hidethis").style.display = 'none';
 }
$("#button_hide").hide();
}
</script>
<script type="text/javascript">
$(document).ready(function () {

    $("#hidethis").hide();

});
</script>
<body onload="funHideTR();">
  <div id="page-wrapper">
      <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
              <div class="col-lg-12">
                <h1 class="page-header">
                    <br><br>
                      <b>Edit Pengajuan Sarana & Prasarana</b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
            @include('flash::message')
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::model($id[0], ['route' => ['pengadaan.update', $id[0]], 'method'=>'patch', 'files' => true]) !!}
                            <div class="col-lg-8">
                              <input type="hidden" id="name-field" name="id_form" class="form-control" value="{{ $headerform[0]->id }}"/>
                              <input type="hidden" id="unit-field" name="unit" class="form-control" value="{{ $headerform[0]->unit }}"/>
                              {{-- <input type="hidden" id="name-field" name="pengaju" class="form-control" value="{{ $headerform[0]->pengaju }}"/> --}}
                              <div class="form-group @if($errors->has('pengaju')) has-error @endif">
                                 <label for="pengaju-field">Yang Mengajukan </label>
                              <input type="text" id="pengaju-field" name="pengaju" class="form-control" value="{{ $headerform[0]->pengaju }}"/>
                                 @if($errors->has("pengaju"))
                                  <span class="help-block">{{ $errors->first("pengaju") }}</span>
                                 @endif
                              </div>
                              <div class="form-group @if($errors->has('tanggal_pengajuan')) has-error @endif">
                                 <label for="tanggal_pengajuan-field">Tanggal Pengajuan </label>
                              <input type="date" id="tanggal_pengajuan-field" name="tanggal_pengajuan" class="form-control date-picker" value="{{ $headerform[0]->tanggal_pengajuan }}"/>
                                 @if($errors->has("tanggal_pengajuan"))
                                  <span class="help-block">{{ $errors->first("tanggal_pengajuan") }}</span>
                                 @endif
                              </div>
                              <div class="form-group @if($errors->has('keterangan')) has-error @endif">
                                 <label for="keterangan-field">KETERANGAN</label>
                                 <textarea id="keterangan" class="form-control" name="keterangan" value="{{$headerform[0]->keterangan}}" required>{{$headerform[0]->keterangan}}</textarea>
                                 @if($errors->has("keterangan"))
                                  <span class="help-block">{{ $errors->first("keterangan") }}</span>
                                 @endif
                              </div>
                            <div class="alert alert-info">
                                Detail Barang
                            </div>
                           </div>  
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <div class="col-lg-12">
                          @if ($errors->any())
                              <div class="alert alert-danger">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif 
                          <div class="table-responsive">
                            <table class="table table-stripped" id="dynamic_field">
                                <thead>
                                    <tr>
                                        <th><center></center></th>
                                        <th><center>NAMA ALAT</center></th>
                                        <th><center>JENIS</center></th>
                                        <th><center>MERK</center></th>
                                        <th><center>JUMLAH</center></th>
                                        <th><center>PERKIRAAN</center></th>
                                        <th><center>SUB_TOTAL</center></th>
                                        <th><center>OPTIONS</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php  
                                  $i=1;
                                  @endphp
                                  @foreach($items as $item)
                                  
                                      <tr>
                                          <td><input type="hidden" id="id_item-field" name="id_item_edit[]" class="form-control" value="{{$item->id}}"/></td>
                                          <td >{{-- <select class="itemName form-control" id="kode-field" name="kode_edit[]" type="text"  data-placeholder="{{ $item->nama_barang }}" style="width: 300px;"></select> --}}
                                            <input type="text" maxlength="25" id="nama_barang-field" name="nama_barang_edit[]" class="form-control" value="{{$item->nama_barang}}" style="width: 300px;" required/>
                                          </td>
                                          <td ><input type="text" maxlength="25" id="jenis-field" name="jenis_edit[]" class="form-control" value="{{$item->jenis}}" required/></td>
                                          <td ><input type="text" maxlength="25" id="merk-field" name="merk_edit[]" class="form-control" value="{{$item->merk}}" required/></td>
                                          <td ><input type="number" min="0" max="1000" id="jumlah-field{{ $item->id }}" name="jumlah_edit[]" class="form-control" onchange="kali({{$item->id}})" value="{{$item->jumlah}}" required/></td>
                                          <td ><input type="number" min="0" max="100000000" id="perkiraan-field{{ $item->id }}" name="perkiraan_edit[]" class="form-control" value="{{$item->perkiraan}}" onchange="kali({{$item->id}})" required/></td>
                                          <td ><input type="number" min="0" max="1000000000" id="sub_total-field{{ $item->id }}" name="sub_total_edit[]" class="form-control" value="{{$item->sub_total}}" readonly/></td>
                                          <td>
                                              <a id="" href="/itempengadaandelete/{{$item->id}}" class="btn btn-danger btn_remove" onclick="return confirm('Apakah anda yakin akan menghapus item ini ?');">X</a>
                                          </td>
                                      </tr>
                                     
                                  @endforeach                    
                                  {{-- <button  onClick="toggle();" type="button" name="add" id="add" class="btn btn-success">Add More</button> --}}
                                </tbody>
                            </table>
                          </div>
                            <center>
                                <button type="button" name="add" id="add" class="btn btn-md btn-block btn-success" style="width: 250px">Tambah data barang</button>
                            </center><br/><br/>
                          <div class="modal-footer">
                            <a class="btn btn-link pull-left" href="{{ route('pengadaan.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>  
                            <button type="submit" class="btn btn-primary pull-left">
                                    Simpan
                            </button>
                          </div>  
                        </div>
                      {!! Form::close() !!}
                    
                </div>
            </div>
        </div>
    </div>


@endsection

