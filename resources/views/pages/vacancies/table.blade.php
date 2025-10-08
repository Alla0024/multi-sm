<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="vacancies-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            </thead>
            <tbody>
            @foreach($vacancies as $vacancy)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                                <div class="form-check form-switch">
                                    <input class="form-check-input checkbox-child" data-content="{{$vacancy['id']}}" name="input-toggle_{{$vacancy['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{$vacancy['id']}}">
                                </div>
                        </div>
                    </th>
                    @foreach($fields as $index => $field)
                        @if($index == 'status')
                            @if($vacancy[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                        @else
                         @if($index != 'id' && $field['inTable'])
                            <td>{{ $vacancy[$index] }}</td>
                         @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['vacancies.destroy', $vacancy->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('vacancies.edit', [$vacancy->id]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>
{{--                            {!! Form::button('<i class="bi bi-trash fs-20"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
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
            @include('adminlte-templates::common.paginate', ['records' => $vacancies])
        </div>
    </div>
</div>
