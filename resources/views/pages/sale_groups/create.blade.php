@extends('layouts.app')

@section('content')
    <section class="content-header create-container">
        @include('components.basic.head-form', ['data' => $saleGroup ?? null])
    </section>

    <div class="content px-3 edit-from-block">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'saleGroups.store']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">
                    <li class="nav-item">
                        <button class="nav-link active" type="button" data-tab="main">Головна</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="sales">Акції</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="bonuses_program">Бонусні програми</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="promocode_group">Групи промокодів</button>
                    </li>
                </ul>
                <div class="row card-items">
                    @include('pages.sale_groups.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('saleGroups.index') }}" class="btn btn-default">{{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
