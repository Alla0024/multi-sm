@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{!!  $word['Article_author'] !!}</h1>
                </div>
                <div class="col-sm-2">
                    <form class="view-form" method="GET" action="">
                        @include('components.basic.sort')
                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('articleAuthors.create') }}">
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
            @include('pages.article_authors.table')
        </div>
    </div>

@endsection
