<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="manufacturers-table">

            <thead>

                <tr>
                    @include('components.basic.search')
                </tr>

            </thead>

            <tbody>
            @foreach($manufacturers as $manufacturer)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{$manufacturer['id']}}" name="input-toggle_{{$manufacturer['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{$manufacturer['id']}}">
                            </div>
                        </div>
                    </th>
                    @foreach($fields as $index => $field)
                         @if($index != 'id' && $field['inTable'])
                            <td>{{ $manufacturer[$index] }}</td>
                         @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['manufacturers.destroy', $manufacturer->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
{{--                            <a href="{{ route('manufacturers.show', [$manufacturer->id]) }}"--}}
{{--                               class='btn btn-default butt-show btn-xs'>--}}
{{--                                <i class="bi bi-eye-fill fs-40"></i>--}}
{{--                            </a>--}}
                            <a href="{{ route('manufacturers.edit', [$manufacturer->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $manufacturers])
        </div>
    </div>
</div>
