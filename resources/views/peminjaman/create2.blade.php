@extends('layouts/master')
@section('title','Input Data Sarana & Prasarana')
@section('content')
<!--jquery dinamyc form-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<style type="text/css" media="screen">
input {
  display:block;
  margin:1em 0;
}
#chars {
color:grey;
}
   
</style>
<body>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <br><br>
                      <b>Input Peminjaman Barang</b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
                @include('flash::message')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"> 
                <div class="form-group">
                     <form action="{{route('peminjaman.store')}}" name="add_name" id="add_name" enctype="multipart/form-data" method="POST">
                            <div class="col-lg-8">
                              <div class="form-group @if($errors->has('nama_kegiatan')) has-error @endif">
                                 <label for="name-field">Nama Kegiatan</label>
                              <input type="text" id="name-field" name="nama_kegiatan" class="form-control" value="{{ old("nama_kegiatan") }}"/>
                                 @if($errors->has("nama_kegiatan"))
                                  <span class="help-block">{{ $errors->first("nama_kegiatan") }}</span>
                                 @endif
                              </div>
                              <div class="form-group @if($errors->has('tanggal_kegiatan')) has-error @endif">
                                 <label for="tanggal_kegiatan-field">Tanggal Kegiatan </label>
                              <input type="date" id="tanggal_kegiatan-field" name="tanggal_kegiatan" class="form-control date-picker" value="<?php echo date("Y-m-d"); ?>"/>
                                 @if($errors->has("tanggal_kegiatan"))
                                  <span class="help-block">{{ $errors->first("tanggal_kegiatan") }}</span>
                                 @endif
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="form-group @if($errors->has('waktu')) has-error @endif">
                                     <label for="waktu-field">Waktu Mulai Kegiatan</label>
                                  <input type="time" min="0:0" id="waktu-field" name="waktu_mulai" class="form-control" value="{{ old("waktu") }}"/>
                                     @if($errors->has("waktu"))
                                      <span class="help-block">{{ $errors->first("waktu") }}</span>
                                     @endif
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group @if($errors->has('waktu')) has-error @endif">
                                     <label for="waktu-field">Waktu Selesai Kegiatan</label>
                                  <input type="time" min="0:0" id="waktu-field" name="waktu_selesai" class="form-control" value="{{ old("waktu") }}"/>
                                     @if($errors->has("waktu"))
                                      <span class="help-block">{{ $errors->first("waktu") }}</span>
                                     @endif
                                  </div>
                                </div>
                              </div>

                              <p class="help-block">AM atau PM</p>
                              <div class="form-group @if($errors->has('tempat')) has-error @endif">
                                 <label for="tempat-field">Tempat</label>
                              <input type="text" id="tempat-field" name="tempat" class="form-control" value="{{ old("tempat") }}"/>
                                 @if($errors->has("tempat"))
                                  <span class="help-block">{{ $errors->first("tempat") }}</span>
                                 @endif
                              </div>
                              <div class="form-group @if($errors->has('tanggal_pengajuan')) has-error @endif">
                                 <label for="tanggal_pengajuan-field">Tanggal Pengajuan </label>
                              <input type="date" id="tanggal_pengajuan-field" name="tanggal_pengajuan" class="form-control date-picker" value="<?php echo date("Y-m-d"); ?>"/>
                                 @if($errors->has("tanggal_pengajuan"))
                                  <span class="help-block">{{ $errors->first("tanggal_pengajuan") }}</span>
                                 @endif
                              </div>
                           

                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>  
                            <a class="btn btn-link pull-left" href="{{ route('pengadaan.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                            <input type="hidden" name="roles_id" value="{{Auth::user()->roles}}">  
                            <button type="submit" class="btn btn-primary pull-right">
                                    Submit
                            </button>
                          </div>  
                     </form>  
                </div> 
            </div>
        </div>
            <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
    <script>
      $(function () {
        $(".table").DataTable();
      });
    </script>
</body>

@endsection
