<html>
    <title>Welcome @yield('title')</title>
    <link rel="stylesheet" href="<?php echo app('url')->asset('css/bootstrap.min.css') ?>">
    <script type="text/javascript" src="<?php echo app('url')->asset('js/jquery-1.12.3.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo app('url')->asset('js/bootstrap.min.js')?>"></script>
    <body class="container">
        <div class="row">
            <div class="col-md-12">
                @section('body')
                @show
            </div>
        </div>

    </body>
</html>