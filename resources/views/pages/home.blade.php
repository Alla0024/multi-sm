@extends('layouts.app')
@section('content')

    <div class="content">
        <div class="title">
            Hello {{$user['name']}}!
        </div>


        <form action="{{asset('/edit')}}" method="POST" @submit.prevent="$store.page.ajax($event)">
            @CSRF
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            </div>

            <div class="input-group">
                <span class="input-group-text">With textarea</span>
                <textarea class="form-control" aria-label="With textarea"></textarea>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </form>
    </div>


@endsection
