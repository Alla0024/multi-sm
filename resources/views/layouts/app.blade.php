<!doctype html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        @foreach($styles as $style)
            {!!file_get_contents($style['href']) !!}
        @endforeach
    </style>

    @stack('styles')


</head>
<body x-data>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('page', JSON.parse(@json($alpine)));
    })
</script>

@include('layouts.header')
<div class="main">
    @include('layouts.sidebar')
    @include('layouts.content')
</div>
@include('layouts.footer')


@stack('scripts')

@foreach($scripts as $script)
    <script type="module" src="{{$script['href']}}"></script>
@endforeach

</body>
</html>
