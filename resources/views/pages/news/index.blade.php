@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{!!  $word['New'] !!}</h1>
                </div>
                <div class="col-sm-4">
                    <form class="view-form d-flex gap-2" method="GET" action="">
                        @foreach(request()->except(['perPage', 'page', 'sortBy']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <div style="display: flex; column-gap: 10px; margin-right: 20px">
                            <label for="perPage">{{ $word['show_by'] }}</label>
                            <select name="perPage" id="perPage" onchange="this.form.submit()">
                                @foreach([10, 25, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div style="display: flex; column-gap: 10px">
                            <label for="sortBy">{{ $word['sort_by'] }}</label>
                            <select name="sortBy" id="sortBy" onchange="this.form.submit()">
                                @php
                                    $sortFields = array(
                                        'default' => $word['sort_default'],
                                        'name_asc' => $word['sort_name_asc'],
                                        'name_desc' => $word['sort_name_desc'],
                                        'created_at_asc' => $word['sort_created_at_asc'],
                                        'created_at_desc' => $word['sort_created_at_desc']
                                    );
                                @endphp
                                @foreach($sortFields as $field => $label)
                                    <option value="{{ $field }}" {{ request('sortBy') == $field ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('news.create') }}">
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
            @include('pages.news.table')
        </div>
    </div>

@endsection
