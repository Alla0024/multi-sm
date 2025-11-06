@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                                            <div class="col-sm-6">
                            <div class="title-head">{!!  $word['stockStatuses'] !!}</div>
                            <div class="count-elements">Вього елементів: {{ $stockStatuses->total() }}</div>
                        </div>
                                    </div>
                <div class="col-sm-2">
                    <form class="view-form" method="GET" action="">
                        @include('components.basic.sort')
                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('stockStatuses.create') }}">
                        {!! $word['add'] !!}
                    </a>
                    {!! Form::open(['route' => ['stockStatuses.destroy', ''], 'method' => 'delete', '@submit.prevent = $store.page.deletedItems($event.target)']) !!}
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
            @include('pages.stock_statuses.table')
        </div>
    </div>

@endsection
