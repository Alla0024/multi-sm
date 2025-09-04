@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{!!  $word['New'] !!}</h1>
                </div>
                <div class="col-sm-4">
                    <form class="view-form d-flex gap-2" method="GET" action="{{url()->current()}}">
                        @include('components.basic.sort')

                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('news.create') }}">
                        {!! $word['add'] !!}
                    </a>
                    <div class="btn btn-primary btn-copy float-right" data-action="copy_news" data-name="news_id" @click="$store.page.copyItem($event.target)">
                        {!! $word['copy'] !!}
                    </div>
                    {!! Form::open(['route' => ['news.destroy', ''], 'method' => 'delete', '@submit.prevent = $store.page.deletedItems($event.target)']) !!}
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
            @include('pages.news.table')
        </div>
    </div>

@endsection
