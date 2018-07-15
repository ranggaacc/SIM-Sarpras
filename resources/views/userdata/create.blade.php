@extends('layouts/master')
@section('title','Input Data Sarana & Prasarana')
@section('content')
<link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet"/>
<script src="{{asset('plugins/select2/jquery.min.js')}}"></script>
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<body>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <br>
                        <br>
                          <b>Input Pengguna Baru</b><br><b><h4> SIM-SARPRAS</h4></b>
                    </h1>
                    @include('flash::message')
                </div>
            </div>
            <!-- /.row -->            
            <div class="row">
                <div class="col-lg-6">
                    {!! Form::open(['route' => 'userdata.store', 'files' => true]) !!}
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <div class="form-group @if($errors->has('pegawai')) has-error @endif">
                        <label for="pegawai-field">Pegawai</label>
                        <select name="id_pegawai" id="users" class="form-control" required>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->gelar_depan }} {{ $pegawai->nama }} {{ $pegawai->gelar_belakang }}</option>
                            @endforeach
                        </select>
                       @if($errors->has("pegawai"))
                        <span class="help-block">{{ $errors->first("pegawai") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('role')) has-error @endif">
                        <label for="role-field">Role / Hak akses</label>
                        <select name="id_role" id="roles" class="form-control" data-placeholder="pilih role / hak akses" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" data-placeholder="pilih role / hak akses">{{ $role->nama_role }}</option>
                            @endforeach
                        </select>
                       @if($errors->has("role"))
                        <span class="help-block">{{ $errors->first("role") }}</span>
                       @endif
                    </div>             
                    <div class="form-group @if($errors->has('username')) has-error @endif">
                       <label for="username-field">Username</label>
                    <input type="text" id="username-field" name="username" class="form-control" value="{{ old("username") }}" required/>
                       @if($errors->has("username"))
                        <span class="help-block">{{ $errors->first("username") }}</span>
                       @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" >Sandi</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" >Konfirmasi Sandi</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                    </div>      
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Tambah
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

<script>
        $(document).ready(function(){
            $('#users').select2({
                placeholder: "Pilih pegawai",
                allowClear: true
            });
        });
</script>
<script>
        $(document).ready(function(){
            $('#roles').select2({
                placeholder: "Pilih pegawai",
                allowClear: true
            });
        });
</script>
</body>

@endsection
