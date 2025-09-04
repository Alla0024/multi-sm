@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        {{ $word['edit'] }}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($attributeIcon, ['route' => ['attributeIcons.update', $attributeIcon->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">

                        <li class="nav-item">
                            <button class="nav-link active" type="button" data-tab="main">{{$word["tab_main"]}}</button>
                        </li>
                </ul>
                <div class="row card-items">
                    @include('pages.attribute_icons.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                {!! Form::submit($word['update'], ['class' => 'btn btn-primary update-form']) !!}
                <a href="{{ route('attributeIcons.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
