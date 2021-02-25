<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Quiki Pay</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('favicon.png')}}">
<!-- <link rel="stylesheet" type="text/css" href="assets/animsition-master/dist/css/animsition.min.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.4.1-dist/css/bootstrap.min.css"> -->
<!-- Styles -->
<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

 <!--<link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0/css/font-awesome.min.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="assets/style.css"> -->

</head>
<style>
    body
    {
        background: rgb(225,104,24);
        background: linear-gradient(180deg, rgba(225,104,24,1) 0%, rgba(220,67,70,1) 53%, rgba(213,32,113,1) 100%);
        height: auto;
        background-size:cover;
        background-origin: border-box;
        font-family:sans-serif;
    }
    h1,h2,h3,h4,h5,h6,p,span{
        font-family:sans-serif !important;
    }
</style>

@yield('css')

<body>
     <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
               <div class="btn-group my-4" role="group" aria-label="Basic example">
                  <a href="" class="btn btn-sm btn-info lang" data-lang="en">EN</a>
                  <a href=""  class="btn btn-sm btn-info lang" data-lang="es">ES</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 mt-2">
                <center>
                    @yield('content')
                </center>
            </div>
        </div>
    </div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@yield('js')
    <script>
        $('.lang').click(function(e){
            e.preventDefault();
            var lang = $(this).data('lang');
            console.log(lang);
            $.ajax({
                url: "/pay/change-lang",
                type: 'post',
                data: {lang: lang},
                success: function(resp){
                    
                }
            });
            location.reload();
        });
    </script>
   <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5f9434bd2915ea4ba0966226/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<!-- <script type="text/javascript" src="assets/jQuery/jquery-3.4.0.min.js"></script> -->
<!-- <script type="text/javascript" src="assets/animsition-master/dist/js/animsition.min.js"></script> -->
<!-- <script type="text/javascript" src="assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script> -->
<!-- <script type="text/javascript" src="assets/AngularJs/angular.min.js"></script> -->
<!-- <script type="text/javascript" src="main.js"></script> -->

</body>
</html>
