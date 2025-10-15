@@extends('layouts.app')

@@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if($config->options->localized)
                        <h1>@@lang('models/{{ $config->modelNames->camelPlural }}.plural')</h1>
                    @else
                        <div class="col-sm-6">
                            <div class="title-head">@{!!  $word['{{ $config->modelNames->camelPlural }}'] !!}</div>
                            <div class="count-elements">Вього елементів: @{{ ${!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}->total() }}</div>
                        </div>
                    @endif
                </div>
                <div class="col-sm-2">
                    <form class="view-form" method="GET" action="">
                        @@include('components.basic.sort')
                    </form>
                </div>
                <div class="col-sm-2 action-item">
                    <a class="btn btn-primary float-right"
                       href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.create') }}">
                        @{!! $word['add'] !!}
                    </a>
                    <div class="btn btn-primary btn-copy float-right" data-action="copy_{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}" data-name="{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}_id" @click="$store.page.copyItem($event.target)">
                        @{!! $word['copy'] !!}
                    </div>
                    @{!! Form::open(['route' => ['{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.destroy', ''], 'method' => 'delete', '@submit.prevent = $store.page.deletedItems($event.target)']) !!}
                    <button type="submit" class="btn btn-primary btn-deleted float-right">
                        @{!! $word['deleted'] !!}
                    </button>
                    @{!! Form::close() !!}
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
