@extends('layouts.app')

@section('content')
    <section class="content-header edit-container">
        <div class="container-fluid ">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        {{ $word['edit'] }}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3 edit-from-block">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($store, ['route' => ['stores.update', $store->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('pages..stores.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit($word['save'], ['class' => 'btn btn-primary']) !!}
                {!! Form::submit($word['update'], ['class' => 'btn btn-primary update-form', '@click.prevent = $store.page.ajax($event.target)']) !!}
                <a href="{{ route('stores.index') }}" class="btn btn-default"> {{ $word['cancel'] }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
