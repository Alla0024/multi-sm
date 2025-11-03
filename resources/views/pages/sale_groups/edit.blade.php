@extends('layouts.app')

@section('content')
    <section class="content-header edit-container">
        @include('components.basic.head-form', ['data' => $saleGroup])
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($saleGroup, ['route' => ['saleGroups.update', $saleGroup->id], 'method' => 'patch']) !!}

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
                {!! Form::submit($word['update'], ['class' => 'btn btn-primary update-form', '@click.prevent = $store.page.ajax($event.target)']) !!}
                <a href="{{ route('saleGroups.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
