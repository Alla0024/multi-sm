@extends('layouts.app')

@section('content')
    <section class="content-header edit-container">
        @include('components.basic.head-form', ['data' => $product])
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'patch', 'novalidate']) !!}

            <div class="card-body" x-data="{oversize: @if(isset($product['productOversizes']) && $product['productOversizes']->count() > 0) true @else false @endif}">
                <ul class="nav nav-tabs" id="customTabs">
                    <li class="nav-item">
                        <button class="nav-link active" type="button" data-tab="main">Загальні</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="data">Данні</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="connections">Звязки</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="attributes">Атрибути</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" type="button" data-tab="images">Зображення</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="video">Відео</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="options">Опції</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="instructions">Інструкції</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="similar">Схожі товари</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="count">Кількість товарів</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="filling">Наповнення</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="segment">Сегменти</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="img_category">Картинки в карточці категорії</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="credit">Доступні кредити</button>
                    </li>
                </ul>
                <div class="row card-items">
                    @include('pages.products.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                {!! Form::submit($word['update'], ['class' => 'btn btn-primary update-form', '@click.prevent = $store.page.ajax($event.target)']) !!}
                <a href="{{ route('products.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
