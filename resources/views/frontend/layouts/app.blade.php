<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>alibazar | Home</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="theme-color" content="#fafafa">
    @yield('meta')
    @include('frontend.includes.stylelink')
    @stack('after-styles')
</head>

<body>
@include('frontend.includes.header')

<main>
    @yield('content')
</main>


@include('frontend.includes.footer')


@include('frontend.includes.modal')
<!-- JavaScript Bundle with Popper -->
@include('frontend.includes.scripts')
@stack('after-scripts')
</body>
</html>
