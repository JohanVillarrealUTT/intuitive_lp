<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Intuitive | Administrador</title>

        <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    </head>
    <body>
        
        <input type="hidden" id="enableRegistration" value="{{$enableRegistration}}">

        <div id="app">
            <admin-app></admin-app>
        </div>

        <!-- Scripts -->

        @if (Auth::user())
            <script>
                const authUserId = {{ Auth::getUser()->id }};
            </script>
        @endif

        <script src="{{asset('js/admin.js')}}"></script>
    </body>

</html>
