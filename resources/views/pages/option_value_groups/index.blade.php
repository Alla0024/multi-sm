@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{!!  $word['optionValueGroups'] !!}</h1>
                </div>
                <div class="col-sm-2">
                    <form class="view-form" method="GET" action="">
                        @foreach(request()->except('perPage', 'page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        <div style="display: flex; column-gap: 10px; margin-right: 20px">
                            <label for="perPage">{{$word['show_by']}}</label>
                            <select name="perPage" id="perPage" onchange="this.form.submit()">
                                @foreach([10, 25, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @isset($sortFields)
                            <div style="display: flex; column-gap: 10px">
                                <label for="sortBy">{{ $word['sort_by'] }}</label>
                                <select name="sortBy" id="sortBy" onchange="this.form.submit()">
                                    @foreach($sortFields as $field)
                                        <option value="{{ $field }}" {{ request('sortBy') == $field ? 'selected' : '' }} >
                                            {{ $word['sort_'.$field] }}
                                        </option>
                                     @endforeach
                                </select>
                            </div>
                        @endisset
                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('optionValueGroups.create') }}">
                        {{$word['add']}}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('pages.option_value_groups.table')
        </div>
    </div>

@endsection
