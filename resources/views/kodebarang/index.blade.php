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
                      <b>Daftar Kode Barang </b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
              </div>
            </div>
              @foreach ( $users as $key)       
                @if($key->id_si==1 && $key->id_role==1)
                <div class="btn-toolbar">
                  <a class="btn btn-xl btn-group btn-success pull-right" href="/kodebarang/create"><i class="glyphicon glyphicon-upload"></i> Upload CSV</a>
                </div>
                @endif
              @endforeach
                {{--EXPORT EXCEL--}}
{{--                 @if(Auth::user()->pegawai->user_si['id_role'] == 1)
                <div class="btn-toolbar">
                  <a class="btn btn-xl btn-group btn-success pull-right" href="/kodebarang/create"><i class="glyphicon glyphicon-upload"></i> Upload CSV</a>
                </div>
                @endif --}}
                <br>
                {{--datatable--}}
                @if($count_data>0)
                <div class="row">
                    <div class="col-md-12">
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>KODE BARANG</th>
                                <th>NAMA BARANG</th>
                            </tr>
                        </thead>
                    </table>                
                    </div>
                </div>
                @else
                <div class="alert alert-info col-lg-12">
                    <h3 class="text-center">Empty!</h3>
                </div> 
                @endif
        </div>
    </div>
<script>
$(function () {
  $(".table").DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: "{{ url('/kode-data')}}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'kode_barang', name: 'kode_barang'},
            {data: 'nama_barang', name: 'nama_barang'},
        ],
  });
});
</script>
</body>

@endsection

