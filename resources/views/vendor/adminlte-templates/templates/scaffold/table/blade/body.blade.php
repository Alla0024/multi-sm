<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="{{ $config->modelNames->dashedPlural }}-table">
            <thead>
            <tr>
                @@include('components.basic.search')
            </tr>
            <tr>
                @@if(isset($fields))
                    <th></th>
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
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="@{{  ${!! $config->modelNames->camel !!}['id']}}" name="input-toggle_@{{ ${!! $config->modelNames->camel !!}['id']}}" type="checkbox" role="switch" id="switchCheckChecked_@{{ ${!! $config->modelNames->camel !!}['id']}}">
                            </div>
                        </div>
                    </th>
{{--                    {!! $fieldBody !!}--}}
                    @@foreach($fields as $index => $field)
                        @@if($index == 'status' && $field['inTable'])
                            @@if(${!! $config->modelNames->camel !!}[$index] == 1)
                                <td><div class="status_active">@{{ $word['status_1'] }}</div></td>
                            @@else
                                <td><div class="status_enable">@{{ $word['status_0'] }}</div></td>
                            @@endif
                         @@elseif($index == 'image' && $field['inTable'])
                            <td><img style="width: 140px;" src="@{{isset(${!! $config->modelNames->camel !!}[$index]) && ${!! $config->modelNames->camel !!}[$index] != '' ? 'https://i.svit-matrasiv.com.ua/images/'.${!! $config->modelNames->camel !!}[$index] : '/images/common/no_images.png'}}" alt=""></td>
                         @@else
                             @@if($index != 'id' && $field['inTable'])
                                <td>@{{ ${!! $config->modelNames->camel !!}[$index] }}</td>
                             @@endif
                        @@endif
                    @@endforeach

                    <td  colspan="3">
                        @{!! Form::open(['route' => ['{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.destroy', ${{ $config->modelNames->camel }}->{{ $config->primaryName }}], 'method' => 'delete']) !!}
                        <div class='btn-group'>
{{--                            <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.show', [${!! $config->modelNames->camel !!}->{!! $config->primaryName !!}]) }}"--}}
{{--                               class='btn btn-default butt-show btn-xs'>--}}
{{--                                <i class="bi bi-eye-fill fs-40"></i>--}}
{{--                            </a>--}}
                            <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.edit', [${!! $config->modelNames->camel !!}->{!! $config->primaryName !!}]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>
{{--                            @{!! Form::button('<i class="bi bi-trash fs-20"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
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
