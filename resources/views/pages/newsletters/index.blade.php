@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{!!  $word['newsletters'] !!}</h1>
                </div>
                <div class="col-sm-2">
                    <form class="view-form" method="GET" action="">
                        @isset($sortFields)
                            <div style="display: flex; column-gap: 10px; margin-right: 20px">
                                <label for="sortBy">{{ $word['sort_by'] }}</label>
                                <select name="sortBy" id="sortBy" onchange="this.form.submit()">
                                    @foreach($sortFields as $field)
                                        <option
                                                value="{{ $field }}" {{ request('sortBy') == $field ? 'selected' : '' }}>
                                            {{ $word['sort_'.$field] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endisset
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

                        @php($keep = request()->except(['sortBy','perPage','page']))
                        @foreach($keep as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ e($v) }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ e($value) }}">
                            @endif
                        @endforeach
                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('newsletters.create') }}">
                        {!! $word['add'] !!}
                    </a>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="{{ route('newsletters.create') }}">
                        {!! $word['add'] !!}
                    </a>
                    <div class="btn btn-primary btn-copy float-right" data-action="copy_newsletters" data-name="newsletters_id" @click="$store.page.copyItem($event.target)">
                        {!! $word['copy'] !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('pages.newsletters.table')
        </div>
    </div>

@endsection
