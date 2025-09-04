<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="options-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            <tr>
                @if(isset($fields))
                    <th></th>
                    @foreach($fields as $index => $field)
                         @if($index != 'id' && $field['inTable'])
                            <th>{{ $word['title_'.$index] }}</th>
                        @endif
                    @endforeach
                @endif
                <th colspan="3">{{ $word['action'] }}</th>
            </tr>
            </thead>
            <tbody>
{{--            @dump($options)--}}
            @foreach($options as $option)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{$option['id']}}" name="input-toggle_{{$option['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{$option['id']}}">
                            </div>
                        </div>
                    </th>
                    @foreach($fields as $index => $field)
                        @if($index == 'status')
                            @if($option[$index] == 1)
                                <td><div class="status_active">{{ $word['status_0'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_1'] }}</div></td>
                            @endif
                        @else
                         @if($index != 'id' && $index != 'appears_in_categories' && $index != 'name' && $field['inTable'])
                            <td>{{ $option[$index] }}</td>

                         @elseif($index == 'name')
                                <td style="font-size: 14px; text-align: start">{{ $option[$index] }}</td>
                         @elseif($index == 'appears_in_categories')
                             <td>
                                 <div style="
                                 display: flex;
                                 align-items: start;
                                 flex-wrap: wrap;
                                 width: 100%;
                                 max-width: 580px;
                                 height: auto;
                                 row-gap: 4px;
                                 margin: 0 auto;
                                 font-size: 12px;
                                 ">
                                 @foreach($option[$index] as $category)
                                     <div style="
                                        background: #FBFCFCFF;
                                        padding: 2px 4px;
                                        margin: 1px 4px;
                                        height: 20px;
                                        border: 1px solid #ACACACFF;
                                        border-radius: 4px;
                                     ">{{$category}}</div>
                                 @endforeach
                                 </div>
                             </td>
                         @endif
                        @endif
                    @endforeach

                    <td  >
                        {!! Form::open(['route' => ['options.destroy', $option->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('options.edit', [$option->id]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>
                            {{--  {!! Form::button('<i class="bi bi-trash fs-20"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $options])
        </div>
    </div>
</div>
