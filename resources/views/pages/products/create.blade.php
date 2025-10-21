@extends('layouts.app')

@section('content')
    <section class="content-header create-container">
        @include('components.basic.head-form', ['data' => $product ?? null])
    </section>

    <div class="content px-3 edit-from-block">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'products.store']) !!}

            <div class="card-body">
                <ul class="nav nav-tabs" id="customTabs">
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="main">Загальні</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="data">Данні</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link active" type="button" data-tab="connections">Звязки</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="attributes">Атрибути</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link " type="button" data-tab="images">Зображення</button>
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
                <a href="{{ route('products.index') }}" class="btn btn-default">{{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
