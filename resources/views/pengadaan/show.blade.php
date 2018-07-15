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
                    <br>
                    <br>
                      <b>Detail Pengajuan Pengadaan</b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
            @include('flash::message')
            <br>                         
            <br>
            {{--datatable--}}
            <div class="row">
                <a href="{{ route('pengadaan.edit',  Hashids::encode($id[0])) }}" role="button" class="btn btn-md btn-warning pull-right"><i class="glyphicon glyphicon-edit"></i> Ubah</a> 
                <a href="/pengadaandelete/{{$id[0]}}" class="btn btn-md btn-danger pull-right" onclick="return confirm('Apakah anda yakin akan menghapus item ini ?');"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="thumbnail"> 
                      <div class="caption">
                        <p style="font-family:roboto; color:grey;">Yang Mengajukan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$header[0]->pengaju}}</p>
                        <p style="font-family:roboto; color:grey;">Tanggal Pengajuan&nbsp;&nbsp;&nbsp;&nbsp;: {{date('j F Y', strtotime($header[0]->tanggal_pengajuan))}}</p>
                        <p style="font-family:roboto; color:grey;">Keterangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$header[0]->keterangan}}</p>

                      </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($items->count())
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th><center>NO</center></th>
                                    <th><center>NAMA BARANG</center></th>
                                    <th><center>JENIS</center></th>
                                    <th><center>MERK/TYPE</center></th>
                                    <th><center>JUMLAH</center></th>
                                    <th><center>UNIT</center></th>
                                    <th><center>PERKIRAAN</center></th>
                                    <th><center>SUB_TOTAL</center></th>
                                </tr>
                            </thead>
                              @php  
                              $i=1;
                              $total=0;
                              @endphp
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td><center>{{$i++}}</center></td>
                                    <td><center>{{$item->nama_barang}}</center></td>
                                    <td><center>{{$item->jenis}}</center></td>
                                    <td><center>{{$item->merk}}</center></td>
                                    <td><center>{{$item->jumlah}}</center></td>
                                    <td><center>{{$item->unit}}</center></td>
                                    <td><center>{{$item->perkiraan}}</center></td>
                                    <td><center>{{$item->sub_total}}</center></td>
                                </tr>
                                @php
                                $total+=$item->sub_total;
                                @endphp
                            @endforeach
                                <tr>
                                    <td><center><b>TOTAL</b></center></td>
                                    <td><center></center></td>
                                    <td><center></center></td>
                                    <td><center></center></td>
                                    <td><center></center></td>
                                    <td><center></center></td>
                                    <td><center></center></td>
                                    <td><center>Rp. {{number_format($total)}}</center></td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                    <div class="alert alert-info col-lg-12">
                        <h3 class="text-center">Empty!</h3>
                    </div> 
                    @endif
                    <a class="btn btn-link pull-left" href="{{ route('pengadaan.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
                </div>
            </div>
        </div>
    </div>

</body>

@endsection

