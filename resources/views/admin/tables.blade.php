@extends('layouts/master')
@section('title','Daftar Sarana & Prasarana')
@section('content')
<style>
#keren { 
   color: white; 
   font: bold 24px/45px Helvetica, Sans-Serif; 
   letter-spacing: -1px;  
   background: rgb(0, 0, 0); /* fallback color */
   background: rgba(221, 221, 221, 1);
   padding: 10px; 
}
.img-inventaris{
    display: block;
    max-width:25%;
    height: auto;
</style>
<body>
  <div id="page-wrapper">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            <br><br>

            <b>Daftar Sarana & Prasarana</b><br><b>
            <h4>            
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
            </h4>
            </b>
          </h1>
        </div>
      </div>
        @include('flash::message')
        <br>

        {{--EXPORT EXCEL--}}
        <div class="btn-toolbar">
          <a class="btn btn-xl btn-group btn-primary pull-left" href="{{url('/excelAdmin/'.$id)}}"><i class="fa fa-file-excel-o"></i> Export All Data</a>
          <a href="" class="btn btn-xl btn-default pull-left" role="button" data-toggle="modal" data-target="#ModalPrint2" data-toggle="tooltip" title="Unduh data sesuai inputan Kode, Tahun, Nama, Merk ,dan Lokasi"><i class="fa fa-file-excel-o" ></i> Export Option</a>                        
        </div>
          <br>
          <div class="row">
              <div class="col-md-12">
                  @if($inventariss->count())
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          Data Inventaris
                      </div>
                      <div class="panel-body">
                      <table class="table table-condensed table-striped table-responsive">
                          <thead>
                              <tr>
                                  <th>KODE BARANG</th>
                                  <th>NAMA BARANG</th>
                                  <th><center>TAHUN BARANG</center></th>
                                  <th>LOKASI</th>
                                  <th class="text-center">OPTIONS</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($inventariss as $inventaris)
                                  <tr>
                                      <td>{{$inventaris->kode_barang}}</td>
                                      <td>{{$inventaris->nama_barang}}</td>
                                      <td><center>{{$inventaris->tahun_barang}}</center></td>
                                      <td>{{$inventaris->lokasi}}</td>
                                      <td class="text-center">
                                          <a href="" role="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#ModalInventaris{{$inventaris->id}}"><i class="glyphicon glyphicon-eye-open"></i> Lihat</a>                                             
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
          <!-- Modal Print2-->
              <div class="modal fade" id="ModalPrint2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Unduh Data Inventaris</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="/excelSearchAdmin/{{$id}}" method="get" id="form1">
                          <p>
                            <b>Unduh</b> data sesuai <strong>inputan Kode, Tahun, Nama, Merk ,dan Lokasi </strong>
                          </p>                     
                            <div class="form-group">
                                <input type="text" class="form-control input-sm" name="q" placeholder="Export By Query" />
                            </div>                    
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="form1" value="Submit">Submit</button>
                          </div>
                        </form>
                    </div>
                  </div>
              </div>
          <!-- Modal De
            <!-- Modal PRINT-->  
        @foreach($inventariss as $inventaris)
        <!-- Modal Detail Inventaris-->
          <div class="modal fade in" id="ModalInventaris{{$inventaris->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header hidden-print">
                            <button type="button" class="close" data-dismiss="modal">
                                   <span aria-hidden="true">&times;</span>
                                   <span class="sr-only">Close</span>
                            </button>
                        </div>
                        
                        <!-- Modal Body -->
                        <div class="modal-body">  
                          <div class="panel panel-lg-default">
                            <center>
                              <div id="keren">
                                  <h4 style="font-family:roboto; color:black;">DETAIL INVENTARIS {{ $unit->nama }}</h4>
                              </div>
                              <br>
                            </center>
                            <div class="table-responsive">        
                              <center>
                                @if($inventaris->gambar !=null)
                                  <a href="{{url('/image', $inventaris->gambar)}}" target="_blank"><img class="img-rounded img-inventaris" src="{{asset('imageInventaris/' .$inventaris->gambar) }}" id="" alt="inventaris" width="300" height="auto"></a>
                                @else
                                  <img class="img-rounded img-responsive" src="{{asset('image/noimage.png') }}" id="" alt="inventaris" width="200" height="auto">
                                @endif
                                <br>
                                <b>Foto Barang</b>
                              </center>
                              <br>  
                            <table class="table table-hover" border="0" cellpadding="0" cellspacing="0" style="width:50%;float:left">
                              <tr>
                                <td align="center"><b>ID Inventaris</b></td>
                                <td align="left">{{$inventaris->id}}</td>
                              </tr>
                              <tr>
                                <td align="center"><b>Kode Barang</b></td>
                                {{-- <th>Kode_barang</th> --}}
                                <td align="left">{{$inventaris->kode_barang}}</td>
                              </tr>
                              <tr>
                                <td align="center"><b>Nama Barang</b></td>
                                {{-- <th>Nama_barang</th> --}}
                                <td align="left">{{$inventaris->nama_barang}}</td>
                              </tr>
                              <tr>
                                <td align="center"><b>Merk Barang</b></td>
                                {{-- <th>Merk_barang</th> --}}
                                <td align="left">{{$inventaris->merk_barang}}</td>
                              </tr>
                              <tr>
                                <td align="center"><b>Tahun Barang</b></td>
                                {{-- <th>Tahun_barang</th> --}}
                                <td align="left">{{$inventaris->tahun_barang}}</td>
                              </tr>
                              <tr>
                                <td align="center"><b>Jumlah Barang</b></td>
                                {{-- <th>Jumlah_barang</th> --}}
                                <td align="left">{{$inventaris->jumlah_barang}}</td>
                              </tr>
                              <tr>
                                <td align="center"><b>Satuan</b></td>
                                {{-- <th>Satuan</th> --}}
                                <td align="left">{{$inventaris->satuan}}</td>
                              </tr>
                            </table>
                            <table class="table table-hover" border="0" cellpadding="0" cellspacing="0" style="width:50%;float:right">
                              <tr>
                                <td align="center"><b>Jumlah Harga</b></td>
                                {{-- <th>Jumlah_harga</th> --}}
                                <td align="left">{{$inventaris->jumlah_harga}}</td>
                              </tr>
                              <tr>
                                <td align="center"><b>Sumber Dana</b></td>
                                {{-- <th align="right">Sumber_dana</th> --}}
                                <td align="left">{{$inventaris->sumber_dana}}</td>
                              </tr>
                              <tr>
                                
                                <td style="vertical-align: middle" align="center" rowspan="3"><b>Kondisi Barang</b></td>
                                {{-- <th>Kondisi_barang</th> --}}
                                <td align="left"><b>B&emsp;: </b>{{$inventaris->B}}</td>
                              </tr>
                              <tr>
                                <td align="left"><b>RR : </b>{{$inventaris->RR}}<td>
                              </tr>
                              <tr>
                                <td align="left"><b>RB : </b>{{$inventaris->RB}}</td>
                              </tr>
                              <tr>
                                <td align="center"><b>Keterangan</b></td>
                                {{-- <th align="right">Sumber_dana</th> --}}
                                <td align="left">{{$inventaris->keterangan}}</td>
                              </tr>
                              <tr>
                                <td align="center"><b>Lokasi Barang</b></td>
                                {{-- <th align="right">Sumber_dana</th> --}}
                                <td align="left">{{$inventaris->lokasi}}</td>
                              </tr>
                            </table>
                              </div>
                            </div>              
                          </div>
                          <!--END Modal Body -->
                    </div>
                  </div>
                </div>
              @endforeach
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

