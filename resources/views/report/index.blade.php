<html>
    <head>
        @section('header')
                <div id="app"></div>
                <script src="/js/report/main.js"></script>
        @show
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="container">
            @yield('body')
        </div>
    </body>
</html>
