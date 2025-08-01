@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        {{ $word['edit'] }} {!!  $word['Manufacturer'] !!}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($manufacturer, ['route' => ['manufacturers.update', $manufacturer->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">
                    @isset($inTabs)
                        @foreach($inTabs as $tab)
                            <li class="nav-item">
                                <button class="nav-link active" type="button" data-tab="{{$tab}}">{{$word["tab_".$tab]}}</button>
                            </li>
                        @endforeach
                    @else
                        <li class="nav-item">
                            <button class="nav-link active" type="button" data-tab="main">{{$word["tab_main"]}}</button>
                        </li>
                    @endisset
                </ul>
                <div class="row card-items">
                    @include('pages.manufacturers.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('manufacturers.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
