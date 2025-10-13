@extends('layouts.app')

@section('content')
    <section class="content-header edit-container">
        @include('components.basic.head-form', ['data' => $category])
    </section>

    <div class="content px-3 edit-from-block">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="main">{{$word["tab_main"]}}</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="filter">Фільтра</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" type="button" data-tab="top">Топ продаж</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" type="button" data-tab="attribute">Атрибути</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link active" type="button" data-tab="news">Статті</button>
                    </li>
                </ul>
                <div class="row card-items">
                    @include('pages.categories.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                {!! Form::submit($word['update'], ['class' => 'btn btn-primary update-form', '@click.prevent = $store.page.ajax($event.target)']) !!}
                <a href="{{ route('categories.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
