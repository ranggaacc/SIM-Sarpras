@extends('layouts/master')
@section('title','Input Data Sarana & Prasarana')
@section('content')
<!--jquery dinamyc form-->
<link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" />
{{-- <script src="{{asset('plugins/select2/jquery.min.js')}}"></script> --}}

{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
{{-- <style type="text/css" media="screen">
input {
  display:block;
  margin:1em 0;
}
#chars {
color:grey;
}
   
</style> --}}
<body>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                    <h1 class="page-header">
                        <br><br>
                          @if($unit->nama=='UIH')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Informasi & Humas)</h4></b>
                          @elseif($unit->nama=='UKBB')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Konservasi Budidaya Biofarmaka)</h4></b>
                          @elseif($unit->nama=='UKHP')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Kandang Hewan Percobaan)</h4></b>
                          @elseif($unit->nama=='UPPW')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Pilot Plant & Workshop)</h4></b>
                          @elseif($unit->nama=='LPSB')
                          <b>Pengajuan Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Laboratorium PSB)</h4></b>
                          @endif
                    </h1>
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"> 
                <div class="form-group">
                     <form action="{{route('pengadaan.store')}}" name="add_name" id="add_name" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="id_pegawai" class="form-control" value="{{Auth::user()->pegawai->id}}"/>
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <div class="col-lg-8">
                              {{-- <input type="hidden" id="name-field" name="pengaju" class="form-control" value="{{ Auth::user()->pegawai['nama'] }}" required/> --}}
                              <div class="form-group @if($errors->has('pengaju')) has-error @endif">
                                 <label for="pengaju-field">Yang Mengajukan </label>
                              <input type="text" id="pengaju-field" name="pengaju" class="form-control"/>
                                 @if($errors->has("pengaju"))
                                  <span class="help-block">{{ $errors->first("pengaju") }}</span>
                                 @endif
                              </div>
                              <div class="form-group @if($errors->has('tanggal_pengajuan')) has-error @endif">
                                 <label for="tanggal_pengajuan-field">Tanggal Pengajuan </label>
                              <input type="date" id="tanggal_pengajuan-field" name="tanggal_pengajuan" class="form-control date-picker" value="<?php echo date("Y-m-d"); ?>"/>
                                 @if($errors->has("tanggal_pengajuan"))
                                  <span class="help-block">{{ $errors->first("tanggal_pengajuan") }}</span>
                                 @endif
                              </div>
                              <div class="form-group @if($errors->has('keterangan')) has-error @endif">
                                 <label for="keterangan-field">Keterangan </label>
                              <textarea type="text" id="keterangan-field" name="keterangan" class="form-control date-picker" value="" required></textarea>
                                 @if($errors->has("keterangan"))
                                  <span class="help-block">{{ $errors->first("keterangan") }}</span>
                                 @endif
                              </div>
                            <div class="alert alert-info">
                                Input Detail Barang
                            </div>
                           </div>
                            
                         <div class="col-lg-12">
                          @if ($errors->any())
                              <div class="alert alert-danger">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif 
                          <div class="table-responsive">  
                            <table class="table table-stripped" id="dynamic_field">  
                                <thead>
                                    <tr>
                                        <th><center></center></th>
                                        <th><center>NAMA ALAT</center></th>
                                        <th><center>JENIS</center></th>
                                        <th><center>MERK</center></th>
                                        <th><center>JUMLAH</center></th>
                                        <th><center>PERKIRAAN</center></th>
                                        <th><center>SUB_TOTAL</center></th>
                                        <th><center>OPTIONS</center></th>
                                    </tr>
                                </thead>
                            </table>
                          <center>
                          <button type="button" name="add" id="add" class="btn btn-md btn-block btn-success" style="width: 250px">Tambah data barang</button><br/><br/>
                          </center>
                            <div class="modal-footer">
                              <a class="btn btn-link pull-left" href="{{ route('pengadaan.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>  
                              <button type="submit" class="btn btn-primary pull-left">
                                      Submit
                              </button>
                            </div> 
                          </div>
                        </div>
                     </form>  
                </div> 
            </div>
        </div>
            <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>

<!-- /#wrapper -->
<script type="text/javascript">
    $(document).ready(function(){      
      // var postURL = "<?php echo url('pengadaan.store'); ?>";
      // var i=1;  


      // $('#add').click(function(){  
      //      i++;  
      //      $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td>'+i+'</td><td><select class="itemName form-control" id="kode-field" name="kode[]" type="text" style="width: 200px"></select></td><td><input type="number" id="jumlah-field" maxlength="20" name="jumlah[]" class="form-control" required/></td><td><input type="number" maxlength="20" id="perkiraan-field" name="perkiraan[]" class="form-control" required/></td><td><input type="number" maxlength="20" id="sub_total-field" name="sub_total[]" class="form-control" required/><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      // });  


      // $(document).on('click', '.btn_remove', function(){ 
      // i--; 
      //      var button_id = $(this).attr("id");   
      //      $('#row'+button_id+'').remove();  
      // });  


      // $.ajaxSetup({
      //     headers: {
      //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //     }
      // });
    });  
</script>
<script type="text/javascript">

      // $('.itemName').select2({
      //   placeholder: 'Select an item',
      //   ajax: {
      //     url: "{{ route('autocomplete2') }}",
      //     dataType: 'json',
      //     delay: 250,
      //     processResults: function (data) {
      //       return {
      //         results:  $.map(data, function (item) {

                    
      //               return {
      //                   text:item.nama_barang,
      //                   id: item.id
      //               }
      //           })
      //       };
      //     },
      //     cache: true
      //   }

      // });

</script>
<script>
    var maxLength = 10;
    $('input').keyup(function() {
      var length = $(this).val().length;
      var length = maxLength-length;
      $('#chars').text(length);
    });
</script>

@endsection
