@extends('layouts/master')
@section('title','Input Data Sarana & Prasarana')
@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<body>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <br><br>
                          <b>Edit Profil Pengguna</b><br><b><h4> SIM-SARPRAS</h4></b>
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
            <!-- /.row -->            
            <div class="row">
                <div class="col-lg-6">
                    <form role="form" action="{{route('update.profil',$user->id)}}" enctype="multipart/form-data" method="POST">  
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <input name="id_pegawai" type="hidden" value="{{ $user->id_pegawai}}"/>
                   {{--  <div class="form-group @if($errors->has('username')) has-error @endif">
                       <label for="username-field">Username</label>
                    <input type="text" id="username-field" name="username" class="form-control" value="{{ $user->username}}"/>
                       @if($errors->has("username"))
                        <span class="help-block">{{ $errors->first("username") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('email')) has-error @endif">
                       <label for="email-field">Email</label>
                    <input type="text" id="email-field" name="email" class="form-control" value="{{ $user->email}}"/>
                       @if($errors->has("email"))
                        <span class="help-block">{{ $errors->first("email") }}</span>
                       @endif
                    </div> --}}
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" >Sandi</label>
                        <input id="password" type="password" class="form-control" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" >Konfirmasi Sandi</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                    </div>
{{--                         <div class="form-group">
                            <label>Input Gambar <strong style="color:red">*optional</strong></label>
                            <input type="file" name="image" accept="image/*" capture="camera"  onchange="tampilkanPreview(this,'preview')" value=""/>
                        </div> --}}
                        <img id="preview" width="220px"/>
                        <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                                <a class="btn btn-link pull-left" href="{{ route('user.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                            </div>
                </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
            <!-- /.container-fluid -->

    </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

{{-- <script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
            return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
</script> --}}
<script type="text/javascript">

      $('.itemName').select2({
        placeholder: 'Select an item',
        ajax: {
          url: "{{ route('autocomplete2') }}",
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.code,
                        id: item.code
                    }
                })
            };
          },
          cache: true
        }
      });

</script>
</body>

@endsection
