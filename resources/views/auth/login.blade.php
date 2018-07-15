<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Informasi Manajemen Pusat Studi Biofarmaka IPB</title>
        <link rel="icon" href="{!! asset('images/logoipb.png') !!}"/>
        <!-- CSS -->
       {{--  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500"> --}}
        <link rel="stylesheet" href="{{asset('welcome/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('welcome/font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('welcome/css/form-elements.css')}}">
        <link rel="stylesheet" href="{{asset('welcome/css/style.css')}}">
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="{{asset('images/iconipb.png')}}">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('welcome/ico/apple-touch-icon-144-precomposed.png')}}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('welcome/ico/apple-touch-icon-114-precomposed.png')}}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('welcome/ico/apple-touch-icon-72-precomposed.png')}}">
        <link rel="apple-touch-icon-precomposed" href="{{asset('welcome/ico/apple-touch-icon-57-precomposed.png')}}">
{{--         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css"> --}}
        <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;

        }

        li {
            float: right;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 24px 46px;
            text-decoration: none;
        }
        </style>
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
{{--             <ul>
              <li><a href="#home">About</a></li>
              <li><a href="#news">Peminjaman</a></li>
            </ul> --}}
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">

                            <img src="{{URL::asset('/images/logoipb.png')}}" width="80">
                            <h1>SIM-SARPRAS<strong style="color: #1565C0"> BIOFARMAKA</strong></h1>
                            <b><p style="color:white">Sistem Informasi Manajemen Sarana dan Prasarana Pusat Studi Biofarmaka IPB</p></b>
                        </div>
                    </div>
                    @include('flash::message')
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top-left panel"> 
                                <ul class="nav nav-tabs "> 
                                    <li role="presentation" class="active"><a data-toggle="tab" href="#login"><strong><h5 style="color: #1565C0">LOGIN</h5></strong></a></li>
{{--                                     <li role="presentation"><a data-toggle="tab" href="#signup"><strong><h5>SIGNUP</h5 style="color: #1565C0"></strong></a></li> --}}
                                    <li role="presentation"><a data-toggle="tab" href="#peminjaman"><strong><h5>PEMINJAMAN</h5 style="color: #1565C0"></strong></a></li>
                                </ul>
                            </div>
                            <div class="form-bottom">
                                <div class="tab-content">
                                    <div id="login" class="tab-pane fade in active"> 
                                        <form role="form" action="{{ route('login') }}" method="POST" class="login-form">
                                            {{ csrf_field() }}

                                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                                <label class="sr-only" for="form-email">username</label>
                                                <input type="text" name="username" placeholder="username" class="form-email form-control" id="username" required>
                                                @if ($errors->has('username'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('username') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label class="sr-only" for="form-password">Password</label>
                                                <input type="password" name="password" placeholder="Password" class="form-password form-control" id="password" required>
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                    </label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn"><strong>LOGIN</strong></button>
                                            <center>
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                Forgot Your Password?
                                                </a>
                                            </center>     
                                        </form>
                                    </div>
                                    @include('flash::message')
                                    <div id="peminjaman" class="tab-pane fade">

                                        <p> Silahkan lakukan registrasi akun untuk melakukan peminjaman ruangan.</p>
                                        
                                        <form role="form" action="/addPeminjam" method="POST" class="login-form" enctype="multipart/form-data">
                                            <div class="col-md-6">
                                            {{ csrf_field() }}
                                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                            <div class="form-group{{ $errors->has('username_peminjam') ? ' has-error' : '' }}">
                                                <label class="sr-only" for="username">Username</label>
                                                <input type="text" name="username_peminjam" placeholder="Username" class="form-userusername form-control" id="username_peminjam" value="{{ old('username') }}" required autofocus>
                                                @if ($errors->has('username_peminjam'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('username_peminjam') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label class="sr-only" for="email">Email</label>
                                                <input type="email" name="email" placeholder="Email" class="form-username form-control" id="email" value="{{ old('email') }}" required>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label class="sr-only" for="name">Nama</label>
                                                <input type="text" name="nama" placeholder="Name" class="form-username form-control" id="name" value="{{ old('name') }}" required autofocus>
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('jenis_kelamin') ? ' has-error' : '' }}">
                                            <label class="radio-inline">
                                              <input type="radio" name="jenis_kelamin" value="L">Laki-laki
                                            </label>
                                            <label class="radio-inline">
                                              <input type="radio" name="jenis_kelamin" value="P">Perempuan
                                            </label>
                                                @if ($errors->has('jenis_kelamin'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('jenis_kelamin') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('no_hp') ? ' has-error' : '' }}">
                                                <label class="sr-only" for="no_hp">Nomor HP</label>
                                                <input type="number" min="0" name="no_hp" placeholder="Nomor HP" class="form-no_hp form-control" id="no_hp" value="{{ old('no_hp') }}" required autofocus>
                                                @if ($errors->has('no_hp'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('no_hp') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group{{ $errors->has('telepon') ? ' has-error' : '' }}">
                                                <label class="sr-only" for="telepon">Telepon</label>
                                                <input type="number" min="0" name="telepon" placeholder="Telepon" class="form-telepon form-control" id="telepon" value="{{ old('telepon') }}" required autofocus>
                                                @if ($errors->has('telepon'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('telepon') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('password_peminjam') ? ' has-error' : '' }}">
                                                <label class="sr-only" for="password">Password</label>
                                                <input type="password" name="password_peminjam" placeholder="Password" class="form-password form-control" id="password_peminjam" required>
                                                @if ($errors->has('password_peminjam'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password_peminjam') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('password_peminjam_confirmation') ? ' has-error' : '' }}">
                                                
                                                    <input id="password-confirm" type="password" class="form-control" name="password_peminjam_confirmation" placeholder="Re-password" required>
                                                    @if ($errors->has('password_peminjam_confirmation'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password_peminjam_confirmation') }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                            <div class="form-group @if($errors->has('image')) has-error @endif">
                                               <label>Input Gambar <strong style="color:red">*optional</strong></label>
                                               <input type="file" name="image" accept="image/*"  onchange="tampilkanPreview(this,'preview')" value=""/>
                                               @if($errors->has("image"))
                                                <span class="help-block">{{ $errors->first("image") }}</span>
                                               @endif
                                            </div>
                                        </div>   
                                            <button type="submit" class="btn"><strong>SIGNUP NOW</strong></button>
                                        </form>
                                    </div>

                                </div>        
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                            <div class="social-login-buttons">
                                <a class="btn btn-link-2" href="#">
                                    <i class="fa fa-facebook"></i> Facebook
                                </a>
                                <a class="btn btn-link-2" href="#">
                                    <i class="fa fa-twitter"></i> Twitter
                                </a>
                                <a class="btn btn-link-2" href="#">
                                    <i class="fa fa-google-plus"></i> Google Plus
                                </a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Javascript -->
        <script src="{{asset('welcome/js/jquery-1.11.1.min.js')}}"></script>
        <script src="{{asset('welcome/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('welcome/js/jquery.backstretch.min.js')}}"></script>
        <script src="{{asset('welcome/js/scripts.js')}}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
 --}}
    </body>

</html>
{{-- warna biru#2121e5 --}}