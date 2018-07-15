<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
{{--     <script src="http://code.highcharts.com/highcharts.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    {{-- CSS --}}
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dashboard/vendor/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/vendor/metisMenu/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/dist/css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{asset('dashboard/vendor/morrisjs/morris.css')}}" rel="stylesheet">
    <link href="{{asset('css/rangga.css')}}" rel="stylesheet">
    <!--plugin ajax-->
    <script src="{{asset('plugins/ajax/jquery.min.js')}}"></script>
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('sweetalert-master/dist/sweetalert.css')}}"> --}}
    <!--plugin highcharts-->
    <script src="{{asset('plugins/highcharts/highcharts.js')}}"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css')}}">
    <link href="{{asset('plugins/datepicker/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="{!! asset('images/logoipb.png') !!}"/>

<style>
.footer {  
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1rem;
  text-align: center; 
}

html {
  height: 100%;
  box-sizing: border-box;
}
body {
  position: relative;
  margin: 0;
  padding-bottom: 6rem;
  min-height: 100%;
  font-family: "Helvetica Neue", Arial, sans-serif;
}
</style>
@yield('header')
</head>   
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <!-- Navbar menu top -->
            @include('layouts.menutop')  
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav side-nav" id="side-menu">
                        <!-- Sidebar profil -->
                        @include('layouts.profil')
                        <!-- Sidebar menu -->
                        @include('layouts.sidemenu')
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
        <!-- Footer -->
        @include('layouts.footer')


        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/user.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('dashboard/vendor/metisMenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('dashboard/dist/js/sb-admin-2.js')}}"></script>
        <!-- DataTables -->
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>

        <!-- DataTables -->
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
        <script src="{{asset('plugins/datepicker/moment.min.js')}}"></script>
        <script src="{{asset('plugins/datepicker/bootstrap-datetimepicker.min.js')}}"></script>
        <script>
            function kali(valu){

                var jumlah = $('#jumlah-field'+valu).val();
                var nilai = $('#perkiraan-field'+valu).val();
                
                var j = document.getElementById("sub_total-field"+valu).innerHTML = nilai*jumlah;
                var sub_total = $('#sub_total-field'+valu).val(j);
            }        
        </script>
        <script>
            var panjang = $("#panjang");
            var lebar = $("#lebar");
            var luas = $("#luas");

            $("#lebar").on('change', function() {
              if(panjang.val() && lebar.val()){
                let z = panjang.val() * lebar.val();
                luas.val(z);
              }

            })  
      
        </script>  
        <script type="text/javascript">
            $(document).ready(function(){
                // select init
                $('.itemName').select2({
                placeholder: 'Select Item',
                ajax: {
                  url: "{{ route('autocomplete2') }}",
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    return {
                      results:  $.map(data, function (item) {

                            
                            return {
                                text: item.kode_barang+' - '+item.nama_barang,
                                id: item.id
                            }
                        })
                    };
                  },
                  cache: true
                }

              });

            var harga_satuan = $("#harga_satuan");
            var jumlah_barang = $("#jumlah_barang");
            var jumlah_harga = $("#jumlah_harga");

            $("#jumlah").on('change', function() {
              if(harga_satuan.val() && jumlah_barang.val()){
                let j = jumlah_barang.val() * harga_satuan.val();
                jumlah_harga.val(j);
              }

            })  

            var jumlah_pertama = $("#jumlah-field1");
            var perkiraan_pertama = $("#perkiraan-field1");
            var sub_total_pertama = $("#sub_total-field1");

            $("#row1").on('change', function() {
              if(jumlah_pertama.val() && perkiraan_pertama.val()){
                let j = jumlah_pertama.val() * perkiraan_pertama.val();
                sub_total_pertama.val(j);
              }

            })
            var jumlah = $("#jumlah-fieldedit1");
            var perkiraan = $("#perkiraan-fieldedit1");
            var sub_total = $("#sub_total-fieldedit1");

            $("#hidethis").on('change', function() {
              if(jumlah.val() && perkiraan.val()){
                let j = jumlah.val() * perkiraan.val();
                sub_total.val(j);
              }

            })  
            // do stuff with airline and flightNumber <input>s
          // });
            // dnamic select
            var postURL = "<?php echo url('pengadaan.store'); ?>";
            var i=1;  
// <td>'+i+'</td>
// <select class="itemName form-control" id="kode-field" name="kode[]" type="text" style="width: 300px" required></select>

            $('#add').click(function(){  
               i++;  
               $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td></td><td><input type="text" id="nama_barang-field" maxlength="25" name="nama_barang[]" class="form-control" style="width: 300px" required/></td> <td><input type="text" id="jenis-field" maxlength="25" name="jenis[]" class="form-control" required/></td><td><input type="text" id="merk-field" maxlength="25" name="merk[]" class="form-control" required/></td><td><input type="number" id="jumlah-field'+i+'" max="1000" min="0" name="jumlah[]" min="0" class="form-control" required/></td><td><input type="number" min="0" max="100000000" id="perkiraan-field'+i+'" name="perkiraan[]" min="0" class="form-control" required/></td><td><input type="number" max="1000000000" min="0" id="sub_total-field'+i+'" name="sub_total[]" class="form-control" readonly/><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
                 var elem = '#row'+i+' .itemName';

          $("input[id^='jumlah-field']").each(function() {
            var id = parseInt(this.id.replace("jumlah-field", ""), 10);
            var jumlah = $("#jumlah-field" + id);
            var perkiraan = $("#perkiraan-field" + id);
            var sub_total = $("#sub_total-field" + id);

             $("#row" + id).on('change', function() {
              if(jumlah.val() && perkiraan.val()){
                let j = jumlah.val() * perkiraan.val();
                sub_total.val(j);
              }

            })  
            // do stuff with airline and flightNumber <input>s
          });

                 $(elem).select2({
                  placeholder: 'Select Item',
                  ajax: {
                    url: "{{ route('autocomplete2') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                      return {
                        results:  $.map(data, function (item) {

                              
                              return {
                                  text: item.kode_barang+' - '+item.nama_barang,
                                  id: item.id
                              }
                          })
                      };
                    },
                    cache: true
                  }

                });
            });  


            $(document).on('click', '.btn_remove', function(){ 
            i--; 
               var button_id = $(this).attr("id");   
               $('#row'+button_id+'').remove();  
            });  


            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
      });
              

      </script>
      <script type="text/javascript">
            $(document).ready(function(){

                // select init
                $('.select_item_peminjaman').select2({
                placeholder: 'Ketik ruangan yang akan dipinjam',
                ajax: {
                  url: "{{ route('autocomplete_ruangan') }}",
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    return {
                      results:  $.map(data, function (item) {

                            
                            return {
                                text: item.nama_ruang+' - '+' Kapasitas '+item.kapasitas+' orang',
                                id: item.id
                            }
                        })
                    };
                  },
                  cache: true
                }

              });
            // dnamic select
            var postURL = "<?php echo url('pengadaan.store'); ?>";
            var i=1;  

// <td>'+i+'</td>
            $('#add_item_peminjaman').click(function(){  
               i++;  
               $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td></td><td><select class="select_item_peminjaman form-control" id="kode-field" name="kode[]" type="text" style="width: 300px"></select></td><td><input type="datetime" id="tanggal_mulai" maxlength="20" name="tanggal_mulai[]" class="form-control"/></td><td><input type="datetime" id="tanggal_selesai" maxlength="20" name="tanggal_selesai[]" class="form-control"/></td><td><input type="text" id="keterangan-field" maxlength="20" name="keterangan[]" min="0" class="form-control"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
               var elem = '#row'+i+' .select_item_peminjaman';
               $(elem).select2({
                placeholder: 'Ketik ruangan yang akan dipinjam',
                ajax: {
                  url: "{{ route('autocomplete_ruangan') }}",
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    return {
                      results:  $.map(data, function (item) {

                            
                            return {
                                text: item.nama_ruang+' - '+' Kapasitas '+item.kapasitas+' orang',
                                id: item.id
                            }
                        })
                    };
                  },
                  cache: true
                }

              });
            });  

            $(document).on('click', '.btn_remove', function(){ 
            i--; 
               var button_id = $(this).attr("id");   
               $('#row'+button_id+'').remove();  
            });  


            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
      });
              
        </script>
        <script type="text/javascript">
            $('#waktu_mulai').datetimepicker({
                sideBySide: true
            });
            $('#waktu_selesai').datetimepicker({
                sideBySide: true
            });
            $(function () {
                $('#laporan').datetimepicker({
                    viewMode: 'years',
                    format: 'MM/YYYY',
                });
            });
            $(function () {
                $('#tahun_barang').datetimepicker({
                    viewMode: 'years',
                    format: 'YYYY',
                });
            });
        </script>
{{-- <script>
$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script> --}}
        <!-- TOKEN -->
        <script>
                window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
                ]) !!};
        </script>
</body>
</html>
