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
                      <b>Sarpras Kondisi Baru </b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
            @php
            $B=0;
                for ($i=0 ; $i<$inventarispanel2->count() ; $i++) {
                    
                    $B+=$inventarispanel2[$i]->B;
                }
            @endphp                      
            <div class="row">
                <div class="col-md-6">
                    <div class="thumbnail"> 
                      <div class="caption">
                        <p style="font-family:roboto; color:grey;">Total Sarpras&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{{ $inventarispanel2->count() }} Jenis</p>
                        <p style="font-family:roboto; color:grey;">Jumlah Baru&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Dengan {{ $B }} buah kondisi baru</p>
                      </div>
                    </div>

                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    @if($inventarispanel2->count())
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th><center>NO</center></th>
                                    <th><center>kode Barang</center></th>
                                    <th><center>Nama Barang</center></th>
                                    <th><center>Jumlah Baru</center></th>
                                    <th><center>Tahun Pembelian</center></th>
                                    <th><center>Option</center></th>

                                </tr>
                            </thead>
                              @php  
                              $i=1;
                              @endphp
                            <tbody>
                            @foreach($inventarispanel2 as $inventaris)
                                <tr>
                                    <td><center>{{$i++}}</center></td>
                                    <td><center>{{$inventaris->kode_barang}}</center></td>
                                     <td>{{$inventaris->nama_barang}}</td>
                                    <td><center>{{$inventaris->B}}</center></td>
                                    <td><center>{{$inventaris->tahun_barang}}</center></td>
                                    <td><center><a href="" role="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#ModalInventaris{{$inventaris->id}}"><i class="glyphicon glyphicon-eye-open"></i> View</a></center></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                    <div class="alert alert-info col-lg-12">
                        <h3 class="text-center">Belum ada data</h3>
                    </div> 
                    @endif
                    <a class="btn btn-link pull-left" href="javascript:history.back()"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
                </div>
            </div>
        </div>
          <!-- Modal Detail Inventaris-->
            @foreach($inventarispanel2 as $inventaris)
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
                                          <h4 style="font-family:roboto; color:black;">DETAIL INVENTARIS</h4>
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
                          </div>
                    </div>
              </div>
            @endforeach
    </div>
    <script>
      $(function () {
        $(".table").DataTable();
      });
    </script>
</body>

@endsection

