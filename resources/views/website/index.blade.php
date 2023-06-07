<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content=" {!! csrf_token() !!}" />

    <title>Intuitive | Únete a nuestro equipo!</title>

    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.modal.min.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">

    <!-- <link rel="stylesheet" type="text/css" href="{{ url('css/display.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/flex-grid.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/gutter.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/modifier.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/spacing.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/text-align.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/single-page.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/landing-page-ext.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Global site tag (gtag.js) - Google Ads: 785294264 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-785294264"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    
    gtag('config', 'AW-785294264');
    </script>
</head>

<body>

    <input type="hidden" id="enableRegistration" value="{{$enableRegistration}}">

<div id="landing-app">
    <website-app></website-app>
</div>


<script>
    window.options = @json($options)
</script>
<script src="{{ asset('js/website.js') }}"></script>
</body>
</html>