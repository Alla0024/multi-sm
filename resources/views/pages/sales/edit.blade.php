@extends('layouts.app')

@section('content')
    <section class="content-header edit-container">
        @include('components.basic.head-form', ['data' => $sale])
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($sale, ['route' => ['sales.update', $sale->id], 'method' => 'patch', 'novalidate']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="main">Головна</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link active" type="button" data-tab="segment">Сегменти</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" type="button" data-tab="payment">Оплата</button>
                    </li>
                </ul>
                <div class="row card-items">
                    @include('pages.sales.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                {!! Form::submit($word['update'], ['class' => 'btn btn-primary update-form', '@click.prevent = $store.page.ajax($event.target)']) !!}
                <a href="{{ route('sales.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
