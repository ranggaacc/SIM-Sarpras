@extends('layouts/master')
@section('title','Peminjaman')
@section('content')
<!--jquery dinamyc form-->
<link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" />
<style>
.nav-pills > li.active > a{
    color: red;
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
                      <b>Input Peminjaman Ruang</b><br><b><h4> SIM-SARPRAS</h4></b>
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
            <div class="col-lg-6"> 
                <div class="form-group">
                     <form action="{{route('peminjaman.store')}}" name="peminjaman" id="" enctype="multipart/form-data" method="POST">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                          <div class="form-group @if($errors->has('id_ruangan')) has-error @endif">
                            <label for="waktu_mulai-field">Pilih Ruangan</label>
                            <select class="select_item_peminjaman form-control" id="id_ruangan-field" name="id_ruangan" type="text"></select>
                             @if($errors->has("id_ruangan"))
                              <span class="help-block">{{ $errors->first("id_ruangan") }}</span>
                             @endif
                          </div>
                          <div class="form-group @if($errors->has('tanggal_pengajuan')) has-error @endif">
                             <label for="tanggal_pengajuan-field">Tanggal Pengajuan </label>
                          <input type="date" id="tanggal_pengajuan-field" name="tanggal_pengajuan" class="form-control" value="<?php echo date("Y-m-d"); ?>"/>
                             @if($errors->has("tanggal_pengajuan"))
                              <span class="help-block">{{ $errors->first("tanggal_pengajuan") }}</span>
                             @endif
                          </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @if($errors->has('waktu_mulai')) has-error @endif">
                                       <label for="waktu_mulai-field">Waktu Mulai</label>
                                       <input type="datetime" id="waktu_mulai" maxlength="20" name="waktu_mulai" class="timepicker form-control" required/>
                                       @if($errors->has("waktu_mulai"))
                                        <span class="help-block">{{ $errors->first("waktu_mulai") }}</span>
                                       @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @if($errors->has('waktu_selesai')) has-error @endif">
                                       <label for="waktu_selesai-field">Waktu Selesai</label>
                                       <input type="datetime" id="waktu_selesai" maxlength="20" name="waktu_selesai" class="timepicker form-control" required/>
                                       @if($errors->has("waktu_selesai"))
                                        <span class="help-block">{{ $errors->first("waktu_selesai") }}</span>
                                       @endif
                                    </div>
                                </div>
                            </div>
                          <div class="form-group @if($errors->has('keterangan')) has-error @endif">
                             <label for="name-field">Keterangan</label>
                             <textarea id="keterangan" class="form-control" name="keterangan"></textarea>
                             @if($errors->has("keterangan"))
                              <span class="help-block">{{ $errors->first("keterangan") }}</span>
                             @endif
                          </div>
                          <div class="modal-footer">
                              <a class="btn btn-link pull-left" href="{{ route('peminjaman.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                              <button type="submit" class="btn btn-primary">
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
</body>

@endsection
