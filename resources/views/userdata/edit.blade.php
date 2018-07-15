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
                    {!! Form::model($user, ['route' => ['userdata.update', $user], 'method'=>'patch', 'files' => true]) !!}
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <div class="form-group @if($errors->has('username')) has-error @endif">
                       <label for="username-field">Username</label>
                    <input type="text" id="username-field" name="username" class="form-control" value="{{ $user->username }}"/>
                       @if($errors->has("username"))
                        <span class="help-block">{{ $errors->first("username") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('email')) has-error @endif">
                       <label for="email-field">Email</label>
                    <input type="email" id="email-field" name="email" class="form-control" value="{{ $user->email}}"/>
                       @if($errors->has("email"))
                        <span class="help-block">{{ $errors->first("email") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('role')) has-error @endif">
                       <label for="role-field">Role / Hak akses</label>
                      <select class="form-control" name="role" value="{{$role[0]->id_role}}">
                        <option value="1" @if($role[0]->id_role == '1') selected="true" @endif>ADMINISTRATOR</option>
                        <option value="2" @if($role[0]->id_role == '2') selected="true" @endif>MIDDLE MANAGEMENT</option>
                        <option value="3" @if($role[0]->id_role == '3') selected="true" @endif>EXECUTIVE</option>
                        <option value="4" @if($role[0]->id_role == '4') selected="true" @endif>PEMINJAM</option>
                      </select>
                       @if($errors->has("role"))
                        <span class="help-block">{{ $errors->first("role") }}</span>
                       @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" >Sandi</label>
                        <input id="password" type="password" class="form-control" name="password" >
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
                        <input type="hidden" name="id_pegawai" value="{{ $pegawai->id }}" >
                        <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                                <a class="btn btn-link pull-left" href="{{ route('userdata.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
                            </div>
                    {!! Form::close() !!}
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
