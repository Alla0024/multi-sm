@extends('layouts.app')
@section('content')

    <div class="wrapper">
        <div class="title">
            Hello {{$user['name']}}!
        </div>
    </div>
@endsection
