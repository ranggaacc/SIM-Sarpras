@extends('layouts/master')
@section('title','Daftar Sarana & Prasarana')
@section('content')
<style>
.img-profil{
    display: block;
    max-width: 25%;
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
                      <b>Daftar User </b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
              @include('flash::message')
              <br>                         
                {{--EXPORT EXCEL--}}
                <div class="btn-toolbar">
                  <a class="btn btn-xl btn-group btn-success pull-right" href="/userdata/create"><i class="glyphicon glyphicon-plus"></i> Tambah Pengguna</a>
                </div>
                <br>
                {{--datatable--}}
              <div class="row">
                  <div class="col-md-12">
                      @if($users->count())
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Data Pengguna
                        </div>
                          <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table class="table table-condensed table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA</th>
                                        <th>UNIT</th>
                                        <th>ROLE</th>
                                        <th>NOMOR HP</th>
                                        <th>EMAIL</th>
                                        {{-- <th>CREATED_AT</th> --}}
                                        <th class="text-center">OPTIONS</th>
                                    </tr>
                                </thead>
                                @php
                                $no=1;
                                @endphp
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$user->nama_pegawai}}</td>
                                            <td>{{$user->nama_unit}}</td>
                                            <td>{{$user->nama_role}}</td>
                                            <td>{{$user->nomor_hp}}</td>
                                            <td>{{$user->email}}</td>
                                            {{-- <td>{{$user->created_at}}</td> --}}
                                            <td class="text-center">
                                                <a href="" role="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#Modaluser{{$user->id_user}}"><i class="glyphicon glyphicon-eye-open"></i> Lihat</a>
                                                {{-- <a href="{{ route('userdata.edit', Hashids::encode($user->id_user,10)) }}" role="button" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-edit"></i> Ubah</a> --}}
                                                <a id="" href="/userdelete/{{$user->id_user}}" class="btn btn-xs btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus item ini ?');"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                        </div>
                        @else
                        <div class="alert alert-info col-lg-12">
                            <h3 class="text-center">Belum ada data pengguna</h3>
                        </div> 
                        @endif
                    </div>
                </div>
          <!-- Modal Detail user-->
            @foreach($users as $user)
            <div class="modal fade in" id="Modaluser{{$user->id_user}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
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
                                      <table class="table table-hover">
                                        <tr style="background-color: #ddd">
                                          <td colspan="2" align="center" ><h5 style="font-family:roboto; color:black;">DETAIL USER</h5></td>
                                        </tr>
                                        <tr>
                                          <td align="center" colspan="2">
                                          <br>
                                          @if($user->gambar !=null)
                                            <a href="{{url('/imageProfil', $user->gambar)}}" target="_blank"><img class="img-rounded img-profil" src="{{asset('imageProfil/' .$user->gambar) }}" id="" alt="user" width="300" height="auto"></a>
                                          @else
                                            <img class="img-rounded img-responsive" src="{{asset('image/noimage.png') }}" id="" alt="user" width="200" height="auto">
                                          @endif
                                          <b>Foto Profil</b><br>
                                          </td>
                                        </tr>  
                                        <tr>
                                          <td align="center"><b>ID USER</b></td>
                                          <td align="left">{{$user->id_user}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>ID PEGAWAI</b></td>
                                          <td align="left">{{$user->id_pegawai}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>NAMA</b></td>
                                          {{-- <th>Kode_barang</th> --}}
                                          <td align="left">{{$user->nama_pegawai}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>UNIT</b></td>
                                          {{-- <th>Kode_barang</th> --}}
                                          <td align="left">{{$user->nama_unit}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>USERNAME</b></td>
                                          {{-- <th>Kode_barang</th> --}}
                                          <td align="left">{{$user->username}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>ROLE</b></td>
                                          {{-- <th>Nama_barang</th> --}}
                                          <td align="left">{{$user->nama_role}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>NOMOR HP</b></td>
                                          {{-- <th>Merk_barang</th> --}}
                                          <td align="left">{{$user->nomor_hp}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>EMAIL</b></td>
                                          {{-- <th>Tahun_barang</th> --}}
                                          <td align="left">{{$user->email}}</td>
                                        </tr>
                                        <tr>
                                          <td align="center"><b>CREATED_AT</b></td>
                                          {{-- <th>Jumlah_barang</th> --}}
                                          <td align="left">{{$user->created_at}}</td>
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

