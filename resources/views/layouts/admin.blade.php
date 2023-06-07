<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="_token" content="{!! csrf_token() !!}">

        <title>Intuitive | Administrador</title>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Styles -->

        <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">

        <style>
            #app {
                border-top: solid 1px #eee;
                transition-duration: 0.5s;
                transition-property: height, opacity, transform;
                transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
                overflow: hidden;

                opacity: 0;
                transform: translate(-2em, 0);
            }

            #app.fade {
                opacity: 1;
                transform: none;
            }
        </style>
    </head>

    <body>
        <div id="app">
            <top-bar>
                @if (!Auth::user())
                    <a href="/">
                        <img class="header-logo" src="{{ asset('images/brand-logo.png') }}">
                    </a>
                    <a href="/">Ir a landing page</a>
                @else
                    <router-link to="/">
                        <img class="header-logo" src="{{ asset('images/brand-logo.png') }}">
                    </router-link>
                    <custom-popover>
                        <ul>
                            <li>
                                <router-link v-if="this.$route.name === 'home'" to="/usuarios">Usuarios</router-link>
                                <router-link v-else to="/">Candidatos</router-link>
                            </li>
                            <li>
                                <a href="{{ url('/admin/salir') }}">Cerrar sesión</a>
                            </li>
                        </ul>
                    </custom-popover>
                @endif
            </top-bar>
            
            @if (Auth::user())
                <data-bar></data-bar>
            @endif

            <main class="content">
                @yield('content')
            </main>

            <admin-footer></admin-footer>
           
        </div>

        <!-- Scripts -->

        @if (Auth::user())
            <script>
                const API_KEY = '{!! env('API_KEY') !!}';
                const authUserId = {{ Auth::getUser()->id }};
            </script>
        @endif
        
        @yield('scripts')
        
        <script>
            function onReady(callback) {
                var intervalID = window.setInterval(checkReady, 500)

                function checkReady() {
                    if (document.getElementsByTagName('body')[0] !== undefined) {
                    window.clearInterval(intervalID)
                    callback.call(this)
                    }
                }
            }

            function show(id, value) {
                document.getElementById(id).style.display = value ? document.getElementById(id).classList.toggle('fade') : 'none'
            }

            onReady(function() {
                show('app', true)
            })
        </script>
        <script src="{{ asset('js/login.js') }}"></script>
    </body>
</html>