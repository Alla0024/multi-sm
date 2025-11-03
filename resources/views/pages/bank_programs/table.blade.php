<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="bank-programs-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            </thead>
            <tbody>
            @foreach($bankPrograms as $bankProgram)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{  $bankProgram['id']}}" name="input-toggle_{{ $bankProgram['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{ $bankProgram['id']}}">
                            </div>
                        </div>
                    </th>

                    @foreach($fields as $index => $field)
                        @if($index == 'status' && $field['inTable'])
                            @if($bankProgram[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                         @elseif($index == 'image' && $field['inTable'])
                            <td><img style="width: 140px; border: 0.7px solid rgba(172, 172, 172, 0.20);" src="{{isset($bankProgram[$index]) && $bankProgram[$index] != '' ? 'https://i.svit-matrasiv.com.ua/images/'.$bankProgram[$index] : '/images/common/no_images.png'}}" alt=""></td>
                         @else
                             @if($index != 'id' && $field['inTable'])
                                <td>{{ $bankProgram[$index] }}</td>
                             @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['bankPrograms.destroy', $bankProgram->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>




                            <a href="{{ route('bankPrograms.edit', [$bankProgram->id]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>

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
            @include('adminlte-templates::common.paginate', ['records' => $bankPrograms])
        </div>
    </div>
</div>
