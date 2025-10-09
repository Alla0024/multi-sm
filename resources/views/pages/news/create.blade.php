@extends('layouts.app')

@section('content')
    <section class="content-header create-container">
        @include('components.basic.head-form', ['data' => $news ?? null])
    </section>

    <div class="content px-3 edit-from-block">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'news.store']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">
                    <li class="nav-item">
                        <button class="nav-link active" type="button"
                                data-tab="main">{{$word["tab_main"]}}</button>
                    </li>
                        <li class="nav-item">
                            <button class="nav-link " type="button"
                                    data-tab="product">{{$word["tab_products"]}}</button>
                        </li>
                </ul>
                <div class="row card-items">
                    @include('pages.news.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('news.index') }}" class="btn btn-default">{{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
