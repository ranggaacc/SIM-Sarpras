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
                      <b>Detail </b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
              @include('flash::message')
              <br>                         
            <br>
            {{--datatable--}}
            @if(Auth::user()->roles!='ADMIN') 
            <div class="row">
                <a href="{{ route('pengadaan.edit', $id) }}" role="button" class="btn btn-md btn-warning pull-right"><i class="glyphicon glyphicon-edit"></i> Edit</a> &nbsp;
                <a href="/pengadaandelete/{{$id}}" class="btn btn-md btn-danger pull-right" onclick="return confirm('Apakah anda yakin akan menghapus item ini ?');"><i class="glyphicon glyphicon-trash"></i> Delete</a>
            </div>
            @endif
            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="thumbnail"> 
                      <div class="caption">

                        <p style="font-family:roboto; color:grey;">Nama Kegiatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$header[0]->nama_kegiatan}}</p>
                        <p style="font-family:roboto; color:grey;">Hari/Tanggal Kegiatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{date('j F Y', strtotime($header[0]->tanggal_kegiatan))}}</p>
                        <p style="font-family:roboto; color:grey;">Waktu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$header[0]->waktu_mulai}}-{{$header[0]->waktu_selesai}}</p>
                        <p style="font-family:roboto; color:grey;">Tempat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$header[0]->tempat}}</p>
                        <p style="font-family:roboto; color:grey;">Tanggal Pengajuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{date('j F Y', strtotime($header[0]->tanggal_pengajuan))}}</p>

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
                                    <th><center>KETERANGAN</center></th>
                                    <th><center>JUMLAH</center></th>
                                    <th><center>UNIT</center></th>
                                    <th><center>PERKIRAAN</center></th>
                                    <th><center>SUB_TOTAL</center></th>
                                </tr>
                            </thead>
                              @php  
                              $i=1;
                              @endphp
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td><center>{{$i++}}</center></td>
                                    <td><center>{{$item->keterangan}}</center></td>
                                    <td><center>{{$item->jumlah}}</center></td>
                                    <td><center>{{$item->unit}}</center></td>
                                    <td><center>{{$item->perkiraan}}</center></td>
                                    <td><center>{{$item->sub_total}}</center></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                    <div class="alert alert-info col-lg-12">
                        <h3 class="text-center">Empty!</h3>
                    </div> 
                    @endif
                    <a class="btn btn-link pull-left" href="{{ route('pengadaan.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </div>
        </div>
    </div>

</body>

@endsection

