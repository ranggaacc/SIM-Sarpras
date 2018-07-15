<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SIMAKA IPB</title>

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="top">
            <center><h1 id="title" class="hidden"><span id="logo">BIOFARMAKA<span></span></span></h1></center>
            <center><img src="{{URL::asset('/images/logoipb.png')}}" alt="gambar" class="bg hidden-print" height="80" width="120" /></center>
        </div>
{{--         <div class="login-box animated fadeInUp">
            <div class="box-header">
                <h2>Log In</h2>
            </div>
            <label for="username">Username</label>
            <br/>
            <input type="text" id="username">
            <br/>
            <label for="password">Password</label>
            <br/>
            <input type="password" id="password">
            <br/>
            <button type="submit">Sign In</button>
            <br/>
            <a href="#"><p class="small">Forgot your password?</p></a>
        </div> --}}
    </div>
</body>

<script>
    $(document).ready(function () {
        $('#logo').addClass('animated fadeInDown');
        $("input:text:visible:first").focus();
    });
    $('#username').focus(function() {
        $('label[for="username"]').addClass('selected');
    });
    $('#username').blur(function() {
        $('label[for="username"]').removeClass('selected');
    });
    $('#password').focus(function() {
        $('label[for="password"]').addClass('selected');
    });
    $('#password').blur(function() {
        $('label[for="password"]').removeClass('selected');
    });
</script>

</html>