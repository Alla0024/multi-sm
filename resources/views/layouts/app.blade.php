<!doctype html>
{{--<html lang="uk" data-b-theme="light" x-data :data-b-theme="$store.page.theme">--}}
<html lang="uk" data-b-theme="light" x-data >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Quill -->
    <link rel="stylesheet" href="{{asset('css/quill.bubble.css')}}">
    <link rel="stylesheet" href="{{asset('css/quill.core.css')}}">
    <link rel="stylesheet" href="{{asset('css/quill.snow.css')}}">

    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/formTable.min.css')}}">
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
<div class="wrapper-main">
    @include('layouts.sidebar')
    <div class="main">
        @include('layouts.header')
        <div class="layout">
            @include('components.basic.breadcrumb')
            @include('layouts.content')
        </div>
        @include('layouts.footer')
    </div>
</div>




@stack('scripts')

    <script type="module" src="{{asset('js/app.min.js')}}"></script>
    <script type="module" src="{{asset('/vendor/laravel-filemanager/js/filemanager.js')}}"></script>
    <script type="module" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="module" src="{{asset('js/events.min.js')}}"></script>
    <script type="module" src="{{asset('js/quill/quill.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>
</body>
</html>
