<!DOCTYPE html>
<html>
<head>
    @include('auth.partials.head')
</head>
<body>
    @yield('container')
    
    @include('auth.partials.end')
    @include('sweetalert::alert')
</body>
</html>


