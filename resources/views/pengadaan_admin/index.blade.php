@extends('layouts/master')
@section('title','Daftar Pengajuan Sarana & Prasarana')
@section('content')
<body>
  <div id="page-wrapper">
      <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
              <div class="col-lg-12">
                <h1 class="page-header">
                    <br><br>
                      <b>Daftar Pengadaan </b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
            <div class="row">
              @include('flash::message')
            </div>
                <br>
                <br>
                <br>
                {{--datatable--}}
                <div class="row">
                    <div class="col-md-12">
                        @if($formpengadaans->count())
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Data Pengadaan
                            </div>
                              <!-- /.panel-heading -->
                            <div class="panel-body">
                                <table class="table table-condensed table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th class="text-center">KETERANGAN</th>
                                            <th class="text-center">TANGGAL PENGAJUAN</th>
                                            <th class="text-center">ITEM</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">OPTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach($formpengadaans as $formpengadaan)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{ $formpengadaan->keterangan }}</td>
                                                <td class="text-center">{{date('j F Y', strtotime($formpengadaan->tanggal_pengajuan))}}</td>
                                                <td class="text-center">{{$formpengadaan->item}}</td>
                                                <td class="text-center">
                                                    @if($formpengadaan->approvement=='0')
                                                    <a class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-exclamation-sign"></i> Belum Disetujui</a>
                                                    @elseif($formpengadaan->approvement=='1')
                                                    <a class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Telah Disetujui</a>
                                                    @else
                                                    <a class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove-sign"></i> Tidak Disetujui</a>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    <a href="/pengadaanadmin/{{Hashids::encode($formpengadaan->id)}}" role="button" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-eye-open"></i> Lihat</a>
                                                    @if($formpengadaan->approvement=='1'||$formpengadaan->approvement=='2')
                                                     <form action="/approvement/{{$formpengadaan->id}}" method="POST" style="display: inline;" onclick="return confirm('Apakah anda yakin?');">
                                                        <input type="hidden" name="_method" value="POST">
                                                        <input type="hidden" name="approvement" value="0">
                                                        <input type="hidden" name="id_pegawai" value="{{ $formpengadaan->id_pegawai }}">
                                                        <input type="hidden" name="tanggal_pengajuan" value="{{$formpengadaan->tanggal_pengajuan}}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {{--                                                     <button type="submit" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-trash"></i> Reject</button> --}}
                                                    </form>
                                                    @else
                                                     <form action="/approvement/{{$formpengadaan->id}}" method="POST" style="display: inline;" onclick="return confirm('Apakah anda yakin?');">
                                                        <input type="hidden" name="_method" value="POST">
                                                        <input type="hidden" name="approvement" value="1">
                                                        <input type="hidden" name="id_pegawai" value="{{ $formpengadaan->id_pegawai }}">
                                                        <input type="hidden" name="id_transaksi" value="{{ $formpengadaan->id_transaksi }}">
                                                        <input type="hidden" name="tanggal_pengajuan" value="{{$formpengadaan->tanggal_pengajuan}}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                                        <button type="submit" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok"></i> Setujui
                                                        </button>
                                                    </form>
                                                    <form action="/approvement/{{$formpengadaan->id}}" method="POST" style="display: inline;" onclick="return confirm('Apakah anda yakin?');">
                                                        <input type="hidden" name="_method" value="POST">
                                                        <input type="hidden" name="approvement" value="2">
                                                        <input type="hidden" name="id_pegawai" value="{{ $formpengadaan->id_pegawai }}">
                                                        <input type="hidden" name="tanggal_pengajuan" value="{{$formpengadaan->tanggal_pengajuan}}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Tolak</button>
                                                    </form>
                                                    @endif
                                                    <a href="/generatepdf/{{$formpengadaan->id }}" role="button" style="color:#73879c;"><i class="fa fa-download"></i> Pdf</a>
                                                    <a href="pengadaanadmindelete/{{$formpengadaan->id}}" role="button" style="color:#73879c;" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-trash-o"></i> Hapus</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-info col-lg-12">
                            <h3 class="text-center">Belum ada pengajuan</h3>
                        </div> 
                        @endif
                    </div>
                </div>
        </div>
    </div>
    <script>
      $(function () {
        $(".table").DataTable();
      });
    </script>
</body>

@endsection

