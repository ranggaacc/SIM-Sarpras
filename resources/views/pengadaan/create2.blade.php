@extends('layouts/master')
@section('title','Input Data Sarana & Prasarana')
@section('content')
<!--jquery dinamyc form-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<body>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <br><br>
                      <b>Input Pengadaan Barang</b><br><b><h4> SIM-SARPRAS</h4></b>
                </h1>
                @include('flash::message')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"> 
                <div class="form-group">
                     <form action="{{route('pengadaan.store')}}" name="add_name" id="add_name" enctype="multipart/form-data" method="POST">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>  
                            <table class="table table-bordered-stripped" id="dynamic_field">  
                                <thead>
                                    <tr>
                                        <th>KETERANGAN</th>
                                        <th>JUMLAH</th>
                                        <th>UNIT</th>
                                        <th>PERKIRAAN</th>
                                        <th>SUB_TOTAL</th>
                                        <th>OPTIONS</th>
                                    </tr>
                                </thead>
                                <tr> 

                                    <td>
                                      <input type="text" id="keterangan-field" name="keterangan[]" class="form-control" placeholder="KETERANGAN" required/></input>
                                    </td>
                                    <td>
                                      <input type="numbers" id="jumlah-field" name="jumlah[]" class="form-control" placeholder="JUMLAH" required/>
                                    </td>
                                    <td>
                                      <select class="form-control" name="unit[]" required>
                                          <option value="{{Auth::user()->roles}}">{{Auth::user()->roles}}</option>
                                      </select>
                                    </td>
                                    <td>
                                      <input type="text" id="perkiraan-field" name="perkiraan[]" class="form-control" placeholder="PERKIRAAN" required/>
                                    </td>
                                    <td>
                                      <input type="text" id="sub_total-field" name="sub_total[]" class="form-control" placeholder="SUB TOTAL" required/>
                                    </td>
                                    <td>
                                      <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                                    </td>
                                </tr>  
                            </table>
                            <a class="btn btn-link pull-left" href="{{ route('pengadaan.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                            <input type="hidden" name="roles_id" value="{{Auth::user()->roles}}">  
                            <button type="submit" class="btn btn-primary">
                                    Submit
                            </button>  
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
      var postURL = "<?php echo url('pengadaan.store'); ?>";
      var i=1;  


      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" id="keterangan-field" name="keterangan[]" class="form-control" required/></input></td><td><input type="numbers" id="jumlah-field" name="jumlah[]" class="form-control" required/></td><td><select class="form-control" name="unit[]"><option value="{{Auth::user()->roles}}">{{Auth::user()->roles}}</option></select><td><input type="text" id="perkiraan-field" name="perkiraan[]" class="form-control" required/></td><td><input type="text" id="sub_total-field" name="sub_total[]" class="form-control" required/><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  


      $(document).on('click', '.btn_remove', function(){  
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
</body>

@endsection
