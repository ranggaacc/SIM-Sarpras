@extends('layouts/master')
@section('title','Peminjaman Sarana & Prasarana')
@section('content')
<style>
/* Style the tab */
.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 14px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
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
                      <b>Peminjaman Ruangan Biofarmaka </b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
            <div class="row">
              @include('flash::message')
            </div>
                <br>

                <div class="tab">
                  <button class="tablinks active" onclick="active(event, 'semua_peminjaman')" data-toggle="tab" href="#semua_peminjaman">Semua Jadwal</button>
                  <button class="tablinks" onclick="active(event, 'pengajuan_peminjaman')" data-toggle="tab" href="#pengajuan_peminjaman">Pengajuan Peminjaman</button>
                  <button class="pull-right" data-toggle="modal" data-target="#ModalButton"><i class="fa  fa-file-pdf-o"></i> Laporan Peminjaman Ruangan</button>
                </div>
                <!-- Modal Laporan-->
                <div class="modal fade" id="ModalButton" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Laporan Peminjaman Ruangan</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="/laporan" method="post" id="form1">
                          <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
{{--                           <p>
                            Pilih bulan dan tahun 
                          </p>   --}}                   
{{--                             <div class="form-group">
                                <div class='input-group date' id='laporan'>
                                    <input type='datetime' class="form-control" name="laporan"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div> --}}
                        <div class="form-group @if($errors->has('laporan')) has-error @endif">
                           <p>
                            Pilih bulan dan tahun 
                          </p>                               
                           <input type="datetime" id="laporan" name="laporan" class="timepicker form-control"required/>
{{--                               <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar">
                                  </span>
                              </span> --}}
                           @if($errors->has("laporan"))
                            <span class="help-block">{{ $errors->first("laporan") }}</span>
                           @endif
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
                <br>              
                {{--datatable--}}
              <div class="row">
                  <div class="col-md-12">
                    <div class="tab-content">
                    <div id="semua_peminjaman" class="tab-pane fade in active">
                            @if($all_peminjamans->count())
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Semua Jadwal
                            </div>
                            <div class="panel-body">
                                <table class="table table-condensed table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th><center>NAMA RUANGAN</center></th>
                                            {{-- <th><center>KETERANGAN</center></th> --}}
                                            <th><center>PEMINJAM</center></th>
                                            <th><center>WAKTU MULAI</center></th>
                                            <th><center>WAKTU SELESAI</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach($all_peminjamans as $key)
                                            <tr>
                                                <td width="5%">{{$i++}}</td>
                                                <td width="20%"><center>{{$key->nama_ruang}}</center></td>
                                                {{-- <td width="20%"><center>{{$key->keterangan_peminjaman}}</center></td> --}}
                                                <td width="20%"><center>{{$key->nama}}</center></td>
                                                <td><center>{{date('d-m-Y H:i',strtotime($key->waktu_mulai))}}</center></td>
                                                <td><center>{{date('d-m-Y H:i',strtotime($key->waktu_selesai))}}</center></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              </div>
                            </div>
                            @else
                            <div class="alert alert-info col-lg-12">
                                <h3 class="text-center">Belum ada jadwal terdaftar</h3>
                            </div> 
                            @endif
                    </div>
                    <div id="pengajuan_peminjaman" class="tab-pane fade">
                            @if($peminjamans->count())
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Pengajuan Peminjaman
                            </div>
                            <div class="panel-body">
                                <table class="table table-condensed table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th><center>RUANGAN</center></th>
                                            {{-- <th><center>KETERANGAN</center></th> --}}
                                            <th><center>PEMINJAM</center></th>
                                            <th><center>WAKTU MULAI</center></th>
                                            <th><center>WAKTU SELESAI</center></th>
                                            <th><center>OPTIONS</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach($peminjamans as $key)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td >{{$key->nama_ruang}}</td>
                                                {{-- <td width="8%">{{$key->keterangan_peminjaman}}</td> --}}
                                                <td ><center>{{$key->nama}}</center></td>

                                                <td width="20%"><center>{{date('d-m-Y H:i',strtotime($key->waktu_mulai))}}</center></td>
                                                <td width="20%"><center>{{date('d-m-Y H:i',strtotime($key->waktu_selesai))}}</center></td>
                                                <td class="text-center" width="30%">
                                                  <a href="" role="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#ModalPeminjaman{{$key->id_peminjaman}}"><i class="glyphicon glyphicon-eye-open"></i> Lihat</a>
                                                    <form action="/approvementpeminjaman/{{$key->id_peminjaman}}" method="POST" style="display: inline;" onclick="return confirm('Apakah anda yakin?');">
                                                        <input type="hidden" name="_method" value="POST">
                                                        <input type="hidden" name="approvement" value="1">
                                                        <input type="hidden" name="id_user" value="{{ $key->id_user }}">
                                                        <input type="hidden" name="id_ruangan" value="{{ $key->id_ruangan }}">
                                                        <input type="hidden" name="id_peminjaman" value="{{ $key->id_peminjaman }}">
                                                        {{-- <input type="hidden" name="tanggal_pengajuan" value="{{ $key->tanggal_pengajuan }}"> --}}
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                                        <button type="submit" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok"></i> Setujui
                                                        </button>
                                                    </form>
                                                    <form action="/approvementpeminjaman/{{$key->id_peminjaman}}" method="POST" style="display: inline;" onclick="return confirm('Apakah anda yakin?');">
                                                        <input type="hidden" name="_method" value="POST">
                                                        <input type="hidden" name="approvement" value="2">
                                                        <input type="hidden" name="id_user" value="{{ $key->id_user }}">
                                                        {{-- <input type="hidden" name="tanggal_pengajuan" value="{{ $key->tanggal_pengajuan }}"> --}}
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Tolak</button>
                                                    </form>
                                                    <a href="/peminjamanadmindelete/{{$key->id_peminjaman}}" role="button" style="color:#73879c;" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-trash-o"></i> Hapus</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              </div>
                            </div>
                            @else
                            <div class="alert alert-info col-lg-12">
                                <h3 class="text-center">Belum ada pengajuan peminjaman</h3>
                            </div> 
                            @endif
                    </div>
              </div>
            @foreach($peminjamans as $peminjam)
            <div class="modal fade in" id="ModalPeminjaman{{$peminjam->id_peminjaman}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
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
                                    <div class="table-responsive">        
                                      <table class="table table-striped">
                                          <tr style="background-color: #ddd">
                                            <td colspan="2" align="center" ><h5 style="font-family:roboto; color:black;">DETAIL PEMINJAMAN</h5></td>
                                          </tr>
                                          <tr>
                                            <td align="center" colspan="2">
                                            <b>Foto Ruangan</b><br><br>
                                            @if($peminjam->gambar_ruangan !=null)
                                              <a href="{{url('/imageRuangan', $peminjam->gambar_ruangan)}}" target="_blank"><img class="img-rounded img-responsive" src="{{asset('imageRuangan/' .$peminjam->gambar_ruangan) }}" id="" alt="ruangan" width="300" height="auto"></a>
                                            @else
                                              <img class="img-rounded img-responsive" src="{{asset('image/noimage.png') }}" id="" alt="ruangan" width="200" height="auto">
                                            @endif
                                            </td>
                                          </tr>
                                        </table>
                                        <table class="table table-hover" border="0" cellpadding="0" cellspacing="0" style="width:50%;float:LEFT">
                                            <tr>
                                              <td align="left"><b>Nama Peminjam</b></td>
                                              <td align="left">{{$peminjam->nama}}</td>
                                            </tr>
                                            <tr>
                                              <td align="left"><b>Nomor Handphone</b></td>
                                              <td align="left">{{$peminjam->nomor_hp}}</td>
                                            </tr>
                                            <tr>
                                              <td align="left"><b>Nomor Telepon</b></td>
                                              <td align="left">{{$peminjam->telepon}}</td>
                                            </tr>
                                            <tr>
                                              <td align="left"><b>Email</b></td>
                                              <td align="left">{{$peminjam->email}}</td>
                                            </tr>       
                                            <tr>
                                              <td align="left"><b>Nama Ruangan</b></td>
                                              <td align="left">{{$peminjam->nama_ruang}}</td>
                                            </tr>
                                            <tr>
                                              <td align="left"><b>Keterangan</b></td>
                                              <td align="left">{{$peminjam->keterangan_peminjaman}}</td>
                                            </tr>
                                        </table>
                                        <table class="table table-hover" border="0" cellpadding="0" cellspacing="0" style="width:50%;float:right">

                                            <tr>
                                              <td align="left"><b>Tanggal Pengajuan</b></td>
                                              <td align="left">{{date('d-m-Y',strtotime($peminjam->tanggal_pengajuan))}}</td>
                                            </tr>
                                          <tr>
                                            <td align="left"><b>Waktu Mulai</b></td>
                                            <td align="left">{{date('d-m-Y H:i',strtotime($peminjam->waktu_mulai))}}</td>
                                          </tr>
                                          <tr>
                                            <td align="left"><b>Waktu Selesai</b></td>
                                            <td align="left">{{date('d-m-Y H:i',strtotime($peminjam->waktu_selesai))}}</td>
                                          </tr>
                                          <tr>
                                            <td align="left"><b>Status</b></td>

                                            <td align="left">                                              
                                                 @if($peminjam->status=='0')
                                                <a class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-exclamation-sign"></i> Belum Disetujui</a>
                                                @elseif($peminjam->status=='1')
                                                <a class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Telah Disetujui</a>
                                                @else
                                                <a class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove-sign"></i> Telah Ditolak</a>
                                                @endif
                                            </td>
                                          </tr>
                                        <tr>
                                          <td align="left"><b>Lampiran 1</b></td>
                                          <td align="left"><?php $splitted1 = preg_split('/\//', $peminjam->file1); ?><p> <a href="{{asset($peminjam->file1) }}" style="color: #23527c;" download>{{$splitted1[sizeof($splitted1) - 1]}}</a>
                                          </p>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td align="left"><b>Lampiran 2</b></td>
                                          <td align="left"><?php $splitted2 = preg_split('/\//', $peminjam->file2); ?><p> <a href="{{asset($peminjam->file2) }}" style="color: #23527c;" download>{{$splitted2[sizeof($splitted2) - 1]}}</a>
                                          </p>
                                          </td>
                                        </tr>                                         
                                      </table>
                                    </div>
                                  </div>              
                                </div>
                          </div>
                    </div>
              </div>
            @endforeach
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
                                          <b>Foto Ruangan</b><br><br>
                                          @if($ruangan->gambar !=null)
                                            <a href="{{url('/imageRuangan', $ruangan->gambar)}}" target="_blank"><img class="img-rounded img-responsive" src="{{asset('imageRuangan/' .$ruangan->gambar) }}" id="" alt="ruangan" width="300" height="auto"></a>
                                          @else
                                            <img class="img-rounded img-responsive" src="{{asset('image/noimage.png') }}" id="" alt="ruangan" width="200" height="auto">
                                          @endif
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
<script>
function active(evt, id_tab) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    evt.currentTarget.className += " active";
}
</script>
</body>

@endsection

