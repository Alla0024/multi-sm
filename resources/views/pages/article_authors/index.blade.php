@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="title-head">{!!  $word['Article_author'] !!}</div>
                    <div class="count-elements">Вього елементів: {{$articleAuthors->total()}}</div>
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
                    <div class="btn btn-primary btn-copy float-right" data-action="copy_articleAuthor" data-name="articleAuthor_id" @click="$store.page.copyItem($event.target)">
                        {!! $word['copy'] !!}
                    </div>
                    {!! Form::open(['route' => ['articleAuthors.destroy', ''], 'method' => 'delete', '@submit.prevent = $store.page.deletedItems($event.target)']) !!}
                    <button type="submit" class="btn btn-primary btn-deleted float-right">
                        {!! $word['deleted'] !!}
                    </button>
                    {!! Form::close() !!}
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
