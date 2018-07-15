@extends('layouts/master')
@section('title','Daftar Sarana & Prasarana')
@section('content')
<body>
  <div id="page-wrapper">
      <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
              <div class="col-lg-12">
                    <h1 class="page-header">
                        <br><br>
                          @if($unit->nama=='UIH')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Informasi & Humas)</h4></b>
                          @elseif($unit->nama=='UKBB')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Konservasi Budidaya Biofarmaka)</h4></b>
                          @elseif($unit->nama=='UKHP')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Kandang Hewan Percobaan)</h4></b>
                          @elseif($unit->nama=='UPPW')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Pilot Plant & Workshop)</h4></b>
                          @elseif($unit->nama=='LPSB')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Laboratorium PSB)</h4></b>
                          @endif
                    </h1>
              </div>
            </div>
            <div class="row">
            @include('flash::message')
            </div>
                <br>                       
                {{--CREATE--}}
                <div class="btn-toolbar">
                  <a class="btn btn-xl btn-group btn-success pull-right" href="/pengadaan/create"><i class="glyphicon glyphicon-plus"></i> Pengadaan</a>
                </div>
                <br>
                <br>
                {{--datatable--}}
                <div class="row">
                    <div class="col-md-12">
                        @if($formpengadaans->count())
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          Data Inventaris
                      </div>
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
                                            <td class="text-center">{{ $formpengadaan->keterangan }}</td>
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
                                                <a href="/pengadaan/{{ Hashids::encode($formpengadaan->id)}}" role="button" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-eye-open"></i> Lihat</a>
                                                <a href="{{ route('pengadaan.edit', Hashids::encode($formpengadaan->id)) }}" role="button" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                                <a id="" href="pengadaandelete/{{$formpengadaan->id}}" class="btn btn-xs btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus item ini ?');"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>
                        @else
                        <div class="alert alert-info col-lg-12">
                            <h3 class="text-center">Belum ada data</h3>
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

