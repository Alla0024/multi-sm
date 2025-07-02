@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Langs</h1>
                </div>
                <div class="col-sm-2">
                    <form class="view-form" method="GET" action="">
                        @foreach(request()->except('perPage', 'page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        <label for="perPage">Показувати по:</label>
                        <select name="perPage" id="perPage" onchange="this.form.submit()">
                            @foreach([10, 25, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>
                                {{ $size }}
                                </option>
                                @endforeach
                        </select>
                    </form>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('langs.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('langs.table')
        </div>
    </div>

@endsection
