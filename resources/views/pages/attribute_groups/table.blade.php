<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="attribute-groups-table">
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
            @foreach($attributeGroups as $attributeGroup)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{$attributeGroup['id']}}" name="input-toggle_{{$attributeGroup['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{$attributeGroup['id']}}">
                            </div>
                        </div>
                    </th>

                    @foreach($fields as $index => $field)
                        @if($index == 'status')
                            @if($attributeGroup[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                        @else
                         @if($index != 'id' && $field['inTable'])
                            <td>{{ $attributeGroup[$index] }}</td>
                         @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['attributeGroups.destroy', $attributeGroup->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>




                            <a href="{{ route('attributeGroups.edit', [$attributeGroup->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $attributeGroups])
        </div>
    </div>
</div>
