<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="{{ $config->modelNames->dashedPlural }}-table">
            <thead>
            <tr>
                <form class="search-form" method="GET" action="">
                    @@if(isset($fields))
                        @@foreach($fields as $index => $field)
                            @@if($index != 'id' && $field['inTable'])
                                <th class="">
                                    @@if(isset($field['searchable']) && $field['searchable'])
                                        <div class="">
                                            {{--                    <lable for="@{{ $field['name'] }}"></lable>--}}
                                            <input type="text" name="@{{ $index }}" placeholder="@{{ $word['search_'.$index] }}" value="@{{ request($index) }}">
                                        </div>
                                    @@endif
                                </th>
                            @@endif
                        @@endforeach
                    @@endif
                    <th class="butt-action action-item">
                        <span class="hide">{!! $config->prefixes->getRoutePrefixWith('.') !!}</span>
                        <span class="hide">{!! $config->modelNames->camelPlural !!}</span>
                        <span class="hide">{!! $config->modelNames->dashedPlural !!}</span>
                        <button class="btn btn-primary" type="submit" style="margin: 0 auto 6px">@{{ $word['search'] }}</button>
                        <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}">@{{ $word['cancel'] }}</a>
                    </th>
                </form>
            </tr>
            <tr>
                @@if(isset($fields))
                    @@foreach($fields as $index => $field)
                         @@if($index != 'id' && $field['inTable'])
                            <th>@{{ $word['title_'.$index] }}</th>
                        @@endif
                    @@endforeach
                @@endif
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

{{--                    {!! $fieldBody !!}--}}
                    @@foreach($fields as $index => $field)
                         @@if($index != 'id' && $field['inTable'])
                            <td>@{{ ${!! $config->modelNames->camel !!}[$index] }}</td>
                         @@endif
                    @@endforeach

                    <td  colspan="3">
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
