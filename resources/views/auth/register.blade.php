<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register</title>

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
                            <div class="col-md-8 col-md-offset-2">
                                <br>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Register</div>
                                    <div class="panel-body">
                                        @if (session('status'))
                                            <div class="alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                        {{ csrf_field() }}
            
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="name" class="col-md-4 control-label">Name</label>

                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                            <label for="username" class="col-md-4 control-label">Username</label>

                                            <div class="col-md-6">
                                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                                                @if ($errors->has('username'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('username') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('kontak') ? ' has-error' : '' }}">
                                            <label for="kontak" class="col-md-4 control-label">Kontak</label>

                                            <div class="col-md-6">
                                                <input id="kontak" type="text" class="form-control" name="kontak" value="{{ old('kontak') }}" required>

                                                @if ($errors->has('kontak'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('kontak') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="password" class="col-md-4 control-label">Password</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control" name="password" required>
                                                <input id="roles" type="hidden" class="form-control" name="roles" value="3" required>

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                            </div>
                                        </div>
                                        <input type="hidden" name="roles" value="USER">
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Register
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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