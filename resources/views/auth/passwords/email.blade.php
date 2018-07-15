<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Password</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
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
            <div class="inner-bg">
                <div class="container">
                    <div class="container">
                         <div class="row">
                            <div class="col-sm-8 col-sm-offset-2 text">
                                <img src="{{URL::asset('/images/logoipb.png')}}" width="80">
                                <h1>SIM-SARPRAS<strong style="color: #1565C0"> BIOFARMAKA</strong></h1>
                                <b><p style="color:white">Sistem Informasi Manajemen Sarana dan Prasarana Pusat Studi Biofarmaka IPB</p></b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <br>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Reset Password</div>
                                    <div class="panel-body">
                                        @if (session('status'))
                                            <div class="alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                        @endif

                                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                                            {{ csrf_field() }}

                                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                {{-- <label for="email" class="col-md-4 control-label">E-Mail Address</label> --}}
                                                <div class="col-md-12">
                                                
                                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Input Your Mail Address" required>

                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <button type="submit" class="btn btn-primary">
                                                        Send Password Reset Link
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button type="submit" class="btn btn-info" style="background-color:red;" onclick="window.location.href='/user'">
                                                    Back
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Javascript -->
        <script src="{{asset('welcome/js/jquery-1.11.1.min.js')}}"></script>
        <script src="{{asset('welcome/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('welcome/js/jquery.backstretch.min.js')}}"></script>
        <script src="{{asset('welcome/js/scripts.js')}}"></script>

    </body>

</html>
{{-- warna biru#2121e5 --}}