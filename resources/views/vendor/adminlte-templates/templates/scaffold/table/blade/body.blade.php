<div class="card-body p-0">
    <form class="search-form" method="GET" action="">
        @@foreach($fields as $field)
            <div class="">
                <lable for="@{{ $field }}">@{{ $field }}</lable>
                <input type="text" name="@{{ $field }}" placeholder="@{{ ucfirst(str_replace('_', ' ', $field)) }}" value="@{{ request($field) }}">
            </div>
        @@endforeach


        <div class="butt-action">
            <button class="btn btn-primary" type="submit">Пошук</button>
            <a href="{{ url()->current() }}">Скинути</a>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table" id="{{ $config->modelNames->dashedPlural }}-table">
            <thead>
            <tr>
                {!! $fieldHeaders !!}
@if($config->options->localized)
                <th colspan="3">@lang('crud.action')</th>
@else
                <th colspan="3">Action</th>
@endif
            </tr>
            </thead>
            <tbody>
            @@foreach(${{ $config->modelNames->camelPlural }} as ${{ $config->modelNames->camel }})
                <tr>

                    {!! $fieldBody !!}
                    <td  style="width: 120px">
                        @{!! Form::open(['route' => ['{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.destroy', ${{ $config->modelNames->camel }}->{{ $config->primaryName }}], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.show', [${!! $config->modelNames->camel !!}->{!! $config->primaryName !!}]) }}"
                               class='btn btn-default butt-show btn-xs'>
                                <i class="bi bi-eye-fill fs-40"></i>
                            </a>
                            <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.edit', [${!! $config->modelNames->camel !!}->{!! $config->primaryName !!}]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>
                            @{!! Form::button('<i class="bi bi-trash fs-20"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        @{!! Form::close() !!}
                    </td>
                </tr>
            @@endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            {!! $paginate !!}
        </div>
    </div>
</div>
