@extends('layouts.app')

@section('content')
    <section class="content-header edit-container">
        @include('components.basic.head-form', ['data' => $bannerGroup])
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($bannerGroup, ['route' => ['bannerGroups.update', $bannerGroup->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">
                    <li class="nav-item">
                        <button class="nav-link active" type="button" data-tab="main">{{$word["tab_main"]}}</button>
                    </li>
                </ul>
                <div class="row card-items">
                    @include('pages.banner_groups.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                {!! Form::submit($word['update'], ['class' => 'btn btn-primary update-form', '@click.prevent = $store.page.ajax($event.target)']) !!}
                <a href="{{ route('bannerGroups.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
