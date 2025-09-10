<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="filters-table">
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
            @foreach($filters as $filter)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{  $filter['id']}}" name="input-toggle_{{ $filter['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{ $filter['id']}}">
                            </div>
                        </div>
                    </th>

                    @foreach($fields as $index => $field)
                        @if($index == 'status')
                            @if($filter[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                         @elseif($index == 'image')
                            <td><img style="width: 140px;" src="{{isset($optionValue[$index]) && $optionValue[$index] != '' ? $optionValue[$index] : '/images/common/no_images.png'}}" alt=""></td>
                         @else
                             @if($index != 'id' && $field['inTable'])
                                <td>{{ $filter[$index] }}</td>
                             @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['filters.destroy', $filter->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>




                            <a href="{{ route('filters.edit', [$filter->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $filters])
        </div>
    </div>
</div>
