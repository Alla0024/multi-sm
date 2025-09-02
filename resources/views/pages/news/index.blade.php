@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{!!  $word['New'] !!}</h1>
                </div>
                <div class="col-sm-4">
                    <form class="view-form d-flex gap-2" method="GET" action="">
                        @include('components.basic.sort')

                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('news.create') }}">
                        {!! $word['add'] !!}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('pages.news.table')
        </div>
    </div>

@endsection
