@@extends('layouts.app')

@@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
@if($config->options->localized)
                    <h1>@@lang('models/{{ $config->modelNames->camelPlural }}.plural')</h1>
@else
                    <h1>@{!!  $word['{{ $config->modelNames->camelPlural }}'] !!}</h1>
@endif
                </div>
                <div class="col-sm-2">
                    <form class="view-form" method="GET" action="">
                        @@foreach(request()->except('perPage', 'page') as $key => $value)
                            <input type="hidden" name="@{{ $key }}" value="@{{ $value }}">
                            @@endforeach

                        @@isset($languages)
                            <div style="display: flex; column-gap: 10px; margin-right: 20px">
                                <label for="language_id">@{{ $word['language'] }}</label>
                                <select name="language_id" id="language_id" onchange="this.form.submit()">
                                    <option
                                        value="@{{ null }}" @{{ request('language_id') == null ? 'selected' : '' }}>
                                        @{!! $word['select'] !!}
                                    </option>
                                    @@foreach($languages as $language)
                                        <option
                                            value="@{{ $language->id }}" @{{ request('language_id') == $language->id ? 'selected' : '' }}>
                                            @{!! $language->code !!}
                                        </option>
                                    @@endforeach
                                </select>
                            </div>
                        @@endisset

                        @@isset($sortFields)
                            <div style="display: flex; column-gap: 10px">
                                <label for="sortBy">@{{ $word['sort_by'] }}</label>
                                <select name="sortBy" id="sortBy" onchange="this.form.submit()">
                                    @@foreach($sortFields as $field)
                                        <option value="@{{ $field }}" @{{ request('sortBy') == $field ? 'selected' : '' }} >
                                            @{{ $word['sort_'.$field] }}
                                        </option>
                                     @@endforeach
                                </select>
                            </div>
                        @@endisset

                        <div style="display: flex; column-gap: 10px; margin-right: 20px">
                            <label for="perPage">@{{$word['show_by']}}</label>
                            <select name="perPage" id="perPage" onchange="this.form.submit()">
                                @@foreach([10, 25, 50, 100] as $size)
                                    <option value="@{{ $size }}" @{{ request('perPage', 10) == $size ? 'selected' : '' }}>
                                    @{{ $size }}
                                    </option>
                                    @@endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.create') }}">
                        @{!! $word['add'] !!}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @@include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            {!! $table !!}
        </div>
    </div>

@@endsection
