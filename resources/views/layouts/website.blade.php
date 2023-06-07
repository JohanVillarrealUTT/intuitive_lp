<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content=" {!! csrf_token() !!}" />

    <title>Toyota | Únete a nuestro equipo!</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.modal.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">

    <link rel="stylesheet" type="text/css" href="{{ url('css/display.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/flex-grid.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/gutter.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/modifier.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/spacing.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/text-align.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/single-page.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/landing-page-ext.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-64023000-10', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body>
    {{-- <iframe src="{{asset('audio/tacoma-start.mp3')}}" allow="autoplay" style="display: none" id="iframeAudio" hidden></iframe>  --}}
    <audio controls autoplay hidden>
      <source src="{{asset('audio/tacoma-start.ogg')}}" type="audio/ogg">
      <source src="{{asset('audio/tacoma-start.mp3')}}" type="audio/mpeg">
    </audio>

<div id="app">
    <router-view></router-view>
</div>


<script src="{{ asset('js/website.js') }}"></script>
</body>
</html>