@extends('layouts/master')
@section('title','Daftar Sarana & Prasarana')
@section('content')
<link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" />

  <div id="page-wrapper">
      <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
              <div class="col-lg-12">
                <h1 class="page-header">
                    <br><br>
                      <b>Detail </b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
              @include('flash::message')
              <br>                         
              <br>
            <div class="row">
                <div class="col-lg-6">
                    @if($peminjaman->count())
                    {!! Form::model($peminjaman, ['route' => ['peminjaman.update', $peminjaman], 'method'=>'patch', 'files' => true]) !!}
                          <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                          <div class="form-group @if($errors->has('id_ruangan')) has-error @endif">
                            <input class="hidden form-control" required="true" name="previous_kode" value="{{$peminjaman->ruangan['id']}}">
                            <select class="select_item_peminjaman form-control" id="id_ruangan-field" name="id_ruangan" type="text" data-placeholder="{{ $peminjaman->ruangan['nama_ruang'] }} - {{ $peminjaman->ruangan['kapasitas'] }} Orang"></select>
                             @if($errors->has("id_ruangan"))
                              <span class="help-block">{{ $errors->first("id_ruangan") }}</span>
                             @endif
                          </div>
                          <div class="form-group @if($errors->has('tanggal_pengajuan')) has-error @endif">
                             <label for="tanggal_pengajuan-field">Tanggal Pengajuan </label>
                          <input type="date" id="tanggal_pengajuan-field" name="tanggal_pengajuan" class="form-control" value="{{ $peminjaman->tanggal_pengajuan }}" required/>
                             @if($errors->has("tanggal_pengajuan"))
                              <span class="help-block">{{ $errors->first("tanggal_pengajuan") }}</span>
                             @endif
                          </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @if($errors->has('waktu_mulai')) has-error @endif">
                                       <label for="waktu_mulai-field">Waktu Mulai</label>
                                       <input type="datetime" id="waktu_mulai" maxlength="20" name="waktu_mulai" class="timepicker form-control" value="{{ date('mm/dd/YYYY H:i:s',strtotime($peminjaman->waktu_mulai)) }}" required/>
                                       @if($errors->has("waktu_mulai"))
                                        <span class="help-block">{{ $errors->first("waktu_mulai") }}</span>
                                       @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @if($errors->has('waktu_selesai')) has-error @endif">
                                       <label for="waktu_selesai-field">Waktu Selesai</label>
                                       <input type="datetime" id="waktu_selesai" maxlength="20" name="waktu_selesai" class="timepicker form-control" value="{{ date('mm/dd/YYYY H:i:s',strtotime($peminjaman->waktu_selesai)) }}" required/>
                                       @if($errors->has("waktu_selesai"))
                                        <span class="help-block">{{ $errors->first("waktu_selesai") }}</span>
                                       @endif
                                    </div>
                                </div>
                            </div>
                          <div class="form-group @if($errors->has('keterangan')) has-error @endif">
                             <label for="name-field">Keterangan</label>
                             <textarea id="keterangan" class="form-control" name="keterangan" value="{{ $peminjaman->keterangan }}" required>{{ $peminjaman->keterangan }}</textarea>
                             @if($errors->has("keterangan"))
                              <span class="help-block">{{ $errors->first("keterangan") }}</span>
                             @endif
                          </div>
                          <div class="form-group @if($errors->has('file1')) has-error @endif">
                             <label for="picture-field">Lampiran 1</label>
                          <input type="file" id="file1-field" name="file1" accept="application/msword, application/vnd.ms-excel,text/plain, application/pdf, image/*" class="form-control" value="{{ old("$peminjaman->file1") }}"/>
                             @if($errors->has("file1"))
                              <span class="help-block">{{ $errors->first("file1") }}</span>
                             @endif
                          </div>
                          <div class="form-group @if($errors->has('file2')) has-error @endif">
                             <label for="picture-field">Lampiran 2</label>
                          <input type="file" id="file2-field" name="file2" accept="application/msword, application/vnd.ms-excel,text/plain, application/pdf, image/*" class="form-control" value="{{ old("$peminjaman->file2") }}"/>
                             @if($errors->has("file2"))
                              <span class="help-block">{{ $errors->first("file2") }}</span>
                             @endif
                          </div>
                          <div class="modal-footer">
                              <a class="btn btn-link pull-left" href="{{ route('peminjaman.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
                              <button type="submit" class="btn btn-primary">
                                      Simpan
                              </button>  
                          </div>                        
                      {!! Form::close() !!}
                    @else
                    <div class="alert alert-info col-lg-12">
                        <h3 class="text-center">Empty!</h3>
                    </div> 
                    @endif
                    
                </div>
            </div>
        </div>
    </div>


@endsection

