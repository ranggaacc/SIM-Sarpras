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
                      <b>Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Informasi & Humas)</h4></b>
                      @elseif($unit->nama=='UKBB')
                      <b>Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Konservasi Budidaya Biofarmaka)</h4></b>
                      @elseif($unit->nama=='UKHP')
                      <b>Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Kandang Hewan Percobaan)</h4></b>
                      @elseif($unit->nama=='UPPW')
                      <b>Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Pilot Plant & Workshop)</h4></b>
                      @elseif($unit->nama=='LPSB')
                      <b>Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Laboratorium PSB)</h4></b>
                      @endif
                </h1>
              </div>
            </div>
{{--             <div class="row">
                <div class="col-md-12">
                    <div class="thumbnail"> 
                      <div class="caption">

                        <p style="font-family:roboto; color:grey;">Nama Kegiatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </p>
                        <p style="font-family:roboto; color:grey;">Hari/Tanggal Kegiatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </p>
                        <p style="font-family:roboto; color:grey;">Waktu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </p>
                        <p style="font-family:roboto; color:grey;">Tempat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </p>
                        <p style="font-family:roboto; color:grey;">Tanggal Pengajuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </p>

                      </div>
                    </div>

                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    @if($inventarisgetall->count())
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th><center>NO</center></th>
                                    <th><center>Kode Barang</center></th>
                                    <th><center>Nama Barang</center></th>
                                    <th><center>Tahun Pembelian</center></th>
                                </tr>
                            </thead>
                              @php  
                              $i=1;
                              @endphp
                            <tbody>
                            @foreach($inventarisgetall as $inventaris)
                                <tr>
                                    <td><center>{{$i++}}</center></td>
                                    <td><center>{{$inventaris->kode_barang}}</center></td>
                                    <td>{{$inventaris->nama_barang}}</td>
                                    <td><center>{{$inventaris->tahun_barang}}</center></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                    <div class="alert alert-info col-lg-12">
                        <h3 class="text-center">Empty!</h3>
                    </div> 
                    @endif
                    <a class="btn btn-link pull-left" href="javascript:history.back()"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
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

