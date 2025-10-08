<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="attributes-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            </thead>
            <tbody>
            @foreach($attributes as $attribute)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{$attribute['id']}}" name="input-toggle_{{$attribute['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{$attribute['id']}}">
                            </div>
                        </div>
                    </th>
                    @foreach($fields as $index => $field)
                        @if($index == 'status')
                            @if($attribute[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                        @else
                         @if($index != 'id' && $field['inTable'])
                            <td>{{ $attribute[$index] }}</td>
                         @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['attributes.destroy', $attribute->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>




                            <a href="{{ route('attributes.edit', [$attribute->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $attributes])
        </div>
    </div>
</div>
