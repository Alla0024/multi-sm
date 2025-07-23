@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                            {{ $word['create'] }} {!!  $word['News Category'] !!}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'newsCategories.store']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">
                    @foreach($inTabs as $tab)
                        <li class="nav-item">
                            <button class="nav-link active" type="button" data-tab="{{$tab}}">{{$word["tab_".$tab]}}</button>
                        </li>
                        @endforeach
                </ul>
                <div class="row card-items">
                    @include('pages.news_categories.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('newsCategories.index') }}" class="btn btn-default">{{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
