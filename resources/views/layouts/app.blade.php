<!doctype html>
<html lang="uk" data-b-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/input.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/header.min.css')}}">


    @stack('styles')


</head>
<body x-data>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('page', {});
    })
</script>

@include('layouts.header')
<div class="main">
    @include('layouts.sidebar')
    @include('layouts.content')
</div>
@include('layouts.footer')


@stack('scripts')

    <script type="module" src="{{asset('js/app.min.js')}}"></script>
    <script type="module" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="module" src="{{asset('js/events.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>
</body>
</html>
