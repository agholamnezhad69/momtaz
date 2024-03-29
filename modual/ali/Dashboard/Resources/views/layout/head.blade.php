<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <title>Panel</title>
    <meta name="_token" content="{{csrf_token()}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/assets/persianDataPicker/css/bootstrap.min.css">
    <link rel="stylesheet" href="/panel/css/style.css?v={{uniqid()}}">
    <link rel="stylesheet" href="/panel/css/responsive_991.css" media="(max-width:991px)">
    <link rel="stylesheet" href="/panel/css/responsive_768.css" media="(max-width:768px)">
    <link rel="stylesheet" href="/css/custom.css?v={{uniqid()}}">
    <link rel="stylesheet" href="/panel/css/font.css">
    <link rel="stylesheet" href="/css/jquery.toast.min.css">
    @yield('css')
</head>
