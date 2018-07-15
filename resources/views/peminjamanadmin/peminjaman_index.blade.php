@extends('layouts/master')
@section('title','Peminjaman Sarana & Prasarana')
@section('content')
<body>
  <div id="page-wrapper">
      <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
              <div class="col-lg-12">
                <h1 class="page-header">
                    <br><br>
                      <b>Peminjaman Ruangan Biofarmaka </b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
            <div class="row">
              @include('flash::message')
            </div>
                <br>
{{--                      <div class="alert alert-info">
                                Input Detail Barang
                            </div> --}}
                <br>                       
                {{--CREATE--}}
                <div class="btn-toolbar">
                  <a class="btn btn-xl btn-group btn-success pull-right" href="/peminjaman/create"><i class="glyphicon glyphicon-plus"></i> Pinjam</a>
                </div>
                <br>
                <br>                          
                {{--datatable--}}
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('peminjaman.store')}}" name="peminjaman" id="peminjaman" enctype="multipart/form-data" method="POST">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            @if($peminjamans->count())
                            <div class="table-responsive">
                            <table class="table table-condensed table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAMA RUANG</th>
                                            <th>KAPASITAS</th>
                                            <th>KETERANGAN</th>
                                            <th class="text-center">OPTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach($ruangans as $ruangan)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td width="30%">{{$ruangan->nama_ruang}}</td>
                                                <td width="10%"><center>{{$ruangan->kapasitas}}</center></td>
                                                <td>{{$ruangan->keterangan}}</td>
                                                <td class="text-center" style="color:#73879c;">
                                                    <a href="" role="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#ModalRuangan{{$ruangan->id}}"><i class="glyphicon glyphicon-eye-open"></i> Detail</a>
{{--                                                     <label>
                                                        <input type="checkbox" name="id_ruangan[]" value="{{$ruangan->id}}"> Pinjam
                                                    </label> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
{{--                                 <a class="btn btn-link pull-left" href="{{ route('pengadaan.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a> --}}
{{--                                 <center>
                                    <button type="submit" class="btn btn-md btn-success">
                                            Process
                                    </button>
                                </center>   --}}
                            </div>
                            @else
                            <div class="alert alert-info col-lg-12">
                                <h3 class="text-center">Empty!</h3>
                            </div> 
                            @endif
                        </form>
                    </div>
                </div>
{{--          <!-- Modal Detail ruangan-->
            @foreach($peminjamans as $peminjaman)
            <div class="modal fade in" id="ModalRuangan{{$peminjaman->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
                <div class="modal-dialog modal-md">
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
                                    <div class="table-responsive">        
                                      <table class="table table-striped">
                                        <tr style="background-color: #ddd">
                                          <td colspan="2" align="center" ><h5 style="font-family:roboto; color:black;">DETAIL ruangan</h5></td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>ID Ruangan</b></td>
                                          <td align="left">{{$peminjaman->id}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>UNIT</b></td>
                                          
                                          <td align="left">{{$peminjaman->unit}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>BAGIAN</b></td>
                                          
                                          <td align="left">{{$peminjaman->bagian}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>GEDUNG</b></td>
                                          
                                          <td align="left">{{$peminjaman->gedung}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>NAMA RUANG</b></td>
                                          
                                          <td align="left">{{$peminjaman->nama_ruang}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>KODE RUANG</b></td>
                                          
                                          <td align="left">{{$peminjaman->kode_ruang}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>WING</b></td>
                                          
                                          <td align="left">{{$peminjaman->wing}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>LEVEL</b></td>
                                          
                                          <td align="left">{{$peminjaman->level}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>KAPASITAS</b></td>
                                          
                                          <td align="left">{{$peminjaman->kapasitas}} Orang</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>PANJANG</b></td>
                                          
                                          <td align="left">{{$peminjaman->panjang}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>LEBAR</b></td>
                                          
                                          <td align="left">{{$peminjaman->lebar}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>LUAS</b></td>
                                          
                                          <td align="left">{{$peminjaman->luas}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>LOKASI</b></td>
                                          
                                          <td align="left">{{$peminjaman->lokasi}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>KETERANGAN</b></td>
                                          
                                          <td align="left">{{$peminjaman->keterangan}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>STATUS</b></td>
                                          
                                          <td align="left">{{$peminjaman->status}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>CREATED_AT</b></td>
                                          
                                          <td align="left">{{$peminjaman->created_at}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center" colspan="2">
                                          <b>Foto Profil</b><br><br>
                                          @if($peminjaman->gambar !=null)
                                            <a href="{{url('/imageRuangan', $peminjaman->gambar)}}" target="_blank"><img class="img-rounded img-responsive" src="{{asset('imageRuangan/' .$peminjaman->gambar) }}" id="" alt="ruangan" width="300" height="auto"></a>
                                          @else
                                            <img class="img-rounded img-responsive" src="{{asset('image/noimage.png') }}" id="" alt="ruangan" width="200" height="auto">
                                          @endif
                                          </td>
                                        </tr>    
                                      </table>
                                    </div>
                                  </div>              
                                </div>
                          </div>
                    </div>
              </div>
            @endforeach --}}
        </div>
    </div>
    <script>
      $(function () {
        $(".table").DataTable();
      });
    </script>
</body>

@endsection

