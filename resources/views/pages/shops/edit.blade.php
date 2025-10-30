@extends('layouts.app')

@section('content')
    <section class="content-header edit-container">
        @include('components.basic.head-form', ['data' => $shop])
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($shop, ['route' => ['shops.update', $shop->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="main">Головне</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link active" type="button" data-tab="images">Список зображень</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" type="button" data-tab="open">Відкриття магазину</button>
                    </li>
                </ul>
                <div class="row card-items">
                    @include('pages.shops.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                {!! Form::submit($word['update'], ['class' => 'btn btn-primary update-form', '@click.prevent = $store.page.ajax($event.target)']) !!}
                <a href="{{ route('shops.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
