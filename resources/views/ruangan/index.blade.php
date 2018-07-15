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
.img-ruangan{
    display: block;
    max-width:40%;
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
                      <b>Daftar Ruangan </b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
              @include('flash::message')
              <br>                         
                {{--EXPORT EXCEL--}}
                <div class="btn-toolbar">
                  <a class="btn btn-xl btn-group btn-success pull-right" href="/ruangan/create"><i class="glyphicon glyphicon-plus"></i> Tambah Ruangan</a>
                </div>
                <br>
                {{--datatable--}}
                <div class="row">
                    <div class="col-md-12">
                        @if($ruangans->count())
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Pengajuan Peminjaman
                            </div>
                            <div class="panel-body">
                            <table class="table table-condensed table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA RUANG</th>
                                        <th>KAPASITAS</th>
                                        <th>PEMINJAMAN</th>
                                        <th>KETERANGAN</th>
                                        <th class="text-center">OPTIONS</th>
                                    </tr>
                                </thead>
                                @php
                                $no=1;
                                @endphp
                                <tbody>
                                    @foreach($ruangans as $ruangan)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$ruangan->nama_ruang}}</td>
                                            <td><center>{{$ruangan->kapasitas}}</center></td>
                                            <td><center>
                                                @if($ruangan->status_peminjaman=='1')
                                                <a class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Bisa dipinjam</a>
                                                @else
                                                <a class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove-sign"></i> Tidak bisa</a>
                                                @endif
                                                </center>
                                            </td>
                                            <td>{{$ruangan->keterangan}}</td>
                                            <td class="text-center" width="30%">
                                                <a href="" role="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#ModalRuangan{{$ruangan->id}}"><i class="glyphicon glyphicon-eye-open"></i> Lihat</a>
                                                <a href="{{ route('ruangan.edit', Hashids::encode($ruangan->id,10)) }}" role="button" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                                <a id="" href="/ruangandelete/{{$ruangan->id}}" class="btn btn-xs btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus item ini ?');"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                          </div>
                        @else
                        <div class="alert alert-info col-lg-12">
                            <h3 class="text-center">Belum ada data ruangan</h3>
                        </div> 
                        @endif
                    </div>
                </div>
          <!-- Modal Detail ruangan-->
            @foreach($ruangans as $ruangan)
            <div class="modal fade in" id="ModalRuangan{{$ruangan->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
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
                                          <td colspan="2" align="center" ><h5 style="font-family:roboto; color:black;">DETAIL RUANGAN</h5></td>
                                        </tr>
                                        <tr>
                                          <td align="center" colspan="2">
                                          
                                          @if($ruangan->gambar !=null)
                                            <a href="{{url('/imageRuangan', $ruangan->gambar)}}" target="_blank"><img class="img-rounded img-ruangan" src="{{asset('imageRuangan/' .$ruangan->gambar) }}" id="" alt="ruangan" width="300" height="auto"></a>
                                          @else
                                            <img class="img-rounded img-responsive" src="{{asset('image/noimage.png') }}" id="" alt="ruangan" width="200" height="auto">
                                          @endif
                                          <b>Foto Ruangan</b><br><br>
                                          </td>
                                        </tr>   
                                        <tr>
                                          <td align="center"><b>BAGIAN</b></td>
                                          
                                          <td align="left">{{$ruangan->bagian}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>GEDUNG</b></td>
                                          
                                          <td align="left">{{$ruangan->gedung}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>NAMA RUANG</b></td>
                                          
                                          <td align="left">{{$ruangan->nama_ruang}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>KODE RUANG</b></td>
                                          
                                          <td align="left">{{$ruangan->kode_ruang}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>WING/LEVEL</b></td>
                                          
                                          <td align="left">{{$ruangan->wing}}/{{$ruangan->level}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>KAPASITAS</b></td>
                                          
                                          <td align="left">{{$ruangan->kapasitas}} Orang</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>PANJANG x LEBAR</b></td>
                                          
                                          <td align="left">{{$ruangan->panjang}} x {{$ruangan->lebar}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>LOKASI</b></td>
                                          
                                          <td align="left">{{$ruangan->lokasi}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>KETERANGAN</b></td>
                                          
                                          <td align="left">{{$ruangan->keterangan}}</td>
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
    </div>
    <script>
      $(function () {
        $(".table").DataTable();
      });
    </script>
</body>

@endsection

