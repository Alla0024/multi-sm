@extends('layouts.app')

@section('content')
    <section class="content-header edit-container">
        @include('components.basic.head-form', ['data' => $attributeIcon])
    </section>

    <div class="content px-3 edit-from-block">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($attributeIcon, ['route' => ['attributeIcons.update', $attributeIcon->id], 'method' => 'patch', 'novalidate']) !!}

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
                {!! Form::submit($word['update'], ['class' => 'btn btn-primary update-form', '@click.prevent = $store.page.ajax($event.target)']) !!}
                <a href="{{ route('attributeIcons.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
