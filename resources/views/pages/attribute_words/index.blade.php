@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{!!  $word['attribute_words'] !!}</h1>
                </div>
                <div class="col-sm-2">
                    <form class="view-form" method="GET" action="">
                        @include('components.basic.sort')
                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('attributeWords.create') }}">
                        {!! $word['add'] !!}
                    </a>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('attributeWords.create') }}">
                        {!! $word['add'] !!}
                    </a>
                    <div class="btn btn-primary btn-copy float-right" data-action="copy_attributeWords" data-name="attributeWords_id" @click="$store.page.copyItem($event.target)">
                        {!! $word['copy'] !!}
                    </div>
                    <form method="POST" action="http://localhost/aikqweu/vacancies" accept-charset="UTF-8" @submit.prevent = $store.page.deletedItems($event.target)><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden">
                    <button type="submit" class="btn btn-primary btn-deleted float-right">
                        {!! $word['deleted'] !!}
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('pages.attribute_words.table')
        </div>
    </div>

@endsection
