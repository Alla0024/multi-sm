<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="{{ $config->modelNames->dashedPlural }}-table">
            <thead>
            <tr>
                <form class="search-form" method="GET" action="">

                    @@foreach($fields as $field)
                        @@if($field['name'] != 'id')
                            <th class="">
                                @@if(isset($field['searchable']) && $field['searchable'])
                                    <div class="">
                                        {{--                    <lable for="@{{ $field['name'] }}"></lable>--}}
                                        <input type="text" name="@{{ $field['name'] }}" placeholder="@{{ $word['search_'.$field['name']] }}" value="@{{ request($field['name']) }}">
                                    </div>
                                @@endif
                            </th>
                        @@endif
                    @@endforeach
                    <th class="butt-action">
                        <button class="btn btn-primary" type="submit" style="margin: 0 auto 6px">@{{ $word['search'] }}</button>
                        <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}">@{{ $word['cancel'] }}</a>
                    </th>
                </form>
            </tr>
            <tr>
                @@foreach($fields as $field)
                     @@if($field['name'] != 'id')
                        <th>@{{ $word['title_'.$field['name']] }}</th>
                    @@endif
                @@endforeach

@if($config->options->localized)
                <th colspan="3">@lang('crud.action')</th>
@else
                <th colspan="3">@{{ $word['action'] }}</th>
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
