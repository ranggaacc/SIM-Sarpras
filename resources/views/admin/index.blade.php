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
    max-width: 25%;
    height: auto;
</style>
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
                      <b>Sarana & Prasarana</b><br><b><h4> Sekretariat</h4></b>
                </h1>
              </div>
            </div>
              @include('flash::message')
                <br>
                <div class="tab">
                  <button class="tablinks active" onclick="active(event, 'daftar_inventaris')" data-toggle="tab" href="#daftar_inventaris">Daftar Inventaris</button>
                  <button class="tablinks" onclick="active(event, 'sampah')" data-toggle="tab" href="#sampah">Sampah ({{ $inventaris_trashed->count() }})</button>
                </div>
                <br>  
            <div class="tab-content">
              <div id="daftar_inventaris" class="tab-pane fade in active">                                                                   
                {{--EXPORT EXCEL--}}
                <div class="btn-toolbar">
                  <a class="btn btn-xl btn-group btn-primary pull-left" href="/excelSekretariat"><i class="fa fa-file-excel-o"></i> Export Data</a>
                  <a href="" class="btn btn-xl btn-default pull-left" role="button" data-toggle="modal" data-target="#ModalPrint" data-toggle="tooltip" title="Unduh data sesuai inputan Kode, Tahun, Nama, Merk ,dan Lokasi"><i class="fa fa-file-excel-o"></i> Export Option</a>
                  <a href="" class="btn btn-xl btn-default pull-left" role="button" data-toggle="modal" data-target="#ModalImport"><i class="fa fa-file-excel-o"></i> Import From Excel</a>
                  <a class="btn btn-xl btn-group btn-success pull-right" href="/sekretariat/create"><i class="glyphicon glyphicon-plus"></i> Tambah</a> 
                </div>
                <br>
                {{--datatable--}}
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
                                        <th><center>LOKASI</center></th>
                                        <th>KETERANGAN</th>
                                        <th><center>OPTIONS</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventariss as $inventaris)
                                        <tr>
                                            <td>{{$inventaris->kode_barang}}</td>
                                            <td style="max-width:60px;">{{$inventaris->nama_barang}}</td>
                                            <td><center>{{$inventaris->tahun_barang}}</center></td>
                                            <td><center>{{$inventaris->lokasi}}</center></td>
                                            <td>{{$inventaris->keterangan}}</td>
                                            <td><center>
                                                <a href="" role="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#ModalInventaris{{$inventaris->id}}"><i class="glyphicon glyphicon-eye-open"></i> Lihat</a>
                                                <a href="{{ route('sekretariat.edit', Hashids::encode($inventaris->id)) }}" role="button" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                                <a id="" href="/sekretariatDelete/{{Hashids::encode($inventaris->id)}}" class="btn btn-xs btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus item ini ?');"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                                              </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            <div id="sampah" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-12">
                     
                    @if($inventaris_trashed->count())
                      <div class="btn-toolbar">
                        <a class="btn btn-xl btn-group btn-default pull-left" href="/sekretariatDeletePermanentAll"><i class="fa fa-trash-o"></i> Kosongkan Sampah</a>
                        <a class="btn btn-xl btn-default pull-left" href="/sekretariat_restore_all"><i class="glyphicon glyphicon-repeat"></i> Pulihkan Semua</a> 
                      </div><br>
                      <div class="panel panel-default">
                          <div class="panel-heading">
                              Data Inventaris
                          </div>
                          <!-- /.panel-heading -->
                          <div class="panel-body">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th>KODE BARANG</th>
                                        <th>NAMA BARANG</th>
                                        <th><center>TAHUN BARANG</center></th>
                                        <th><center>LOKASI</center></th>
                                        <th>KETERANGAN</th>
                                        <th><center>OPTIONS</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventaris_trashed as $inventaris)
                                        <tr>
                                            <td>{{$inventaris->kode_barang}}</td>
                                            <td style="max-width:60px;">{{$inventaris->nama_barang}}</td>
                                            <td><center>{{$inventaris->tahun_barang}}</center></td>
                                            <td><center>{{$inventaris->lokasi}}</center></td>
                                            <td>{{$inventaris->keterangan}}</td>
                                            <td>
                                              <center>
                                                <a href="" role="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#ModalInventaris_trashed{{$inventaris->id}}"><i class="glyphicon glyphicon-eye-open"></i> Lihat</a>
                                                <a href="/sekretariat_restore_id/{{$inventaris->id}}" role="button" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-repeat"></i> Pulihkan</a>
                                                <a id="" href="/sekretariatDeletePermanent/{{$inventaris->id}}" class="btn btn-xs btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus item ini selamanya?');"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                                              </center>
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
            </div>
            <!-- Modal IMPORT FROM EXCEL-->
              <div class="modal fade" id="ModalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Import Data Dari File Excel</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        File yang dapat di upload hanya file dengan tipe .xls dengan format header tabel dan posisi tabel seperti pada file ini:
                        <strong>
                           <?php $splitted1 = preg_split('/\//', "/upload/file/Contoh File.xlsx"); ?><a href="{{asset("/upload/file/Contoh File.xlsx") }}" style="color: #23527c;" download>{{$splitted1[sizeof($splitted1) - 1]}}</a>
                        </strong>

                        <strong>
                          <p>
                            <ul>
                            Ketentuan Fail dan data :
                            <li>
                                Samakan posisi tabel seperti pada contoh file diatas
                            </li>
                            <li>
                                Untuk kolom kondisi barang lakukan merge kolom pada kondisi barang seperti pada contoh file diatas
                            </li>
                            <li>
                                Pastikan kode barang tidak kosong
                            </li>
                          </ul>
                          </p>
                        </strong>
                        <form action="/importExcelAdmin" id="form_import" enctype="multipart/form-data" method="POST">
                          <input name="_token" type="hidden" value="{{ csrf_token() }}"/>                     
                            <div class="form-group">
                                <input type="file" class="form-control input-sm" name="import_file" />
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">
                                      Submit
                              </button>
                            </div>                      
                        </form>
                      </div>
                    </div>
                  </div>
              </div>           
              <!-- Modal PRINT-->
              <div class="modal fade" id="ModalPrint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Unduh Data Inventaris</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="/excelSearchSekretariat" method="get" id="form1">
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
          <!-- Modal Detail Inventaris-->
            @foreach($inventariss as $inventaris)
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
                                          <h4 style="font-family:roboto; color:black;">DETAIL INVENTARIS SEKRETARIAT</h4>
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
 <!-- Modal Detail Inventaris_trashed-->
            @foreach($inventaris_trashed as $inventaris)
            <div class="modal fade in" id="ModalInventaris_trashed{{$inventaris->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
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
                                          <h4 style="font-family:roboto; color:black;">DETAIL INVENTARIS SEKRETARIAT</h4>
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

