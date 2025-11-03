<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="individual-entrepreneurs-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            </thead>
            <tbody>
            @foreach($individualEntrepreneurs as $individualEntrepreneur)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{  $individualEntrepreneur['id']}}" name="input-toggle_{{ $individualEntrepreneur['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{ $individualEntrepreneur['id']}}">
                            </div>
                        </div>
                    </th>

                    @foreach($fields as $index => $field)
                        @if($index == 'status' && $field['inTable'])
                            @if($individualEntrepreneur[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                         @elseif($index == 'image' && $field['inTable'])
                            <td><img style="width: 140px; border: 0.7px solid rgba(172, 172, 172, 0.20);" src="{{isset($individualEntrepreneur[$index]) && $individualEntrepreneur[$index] != '' ? 'https://i.svit-matrasiv.com.ua/images/'.$individualEntrepreneur[$index] : '/images/common/no_images.png'}}" alt=""></td>
                         @else
                             @if($index != 'id' && $field['inTable'])
                                <td>{{ $individualEntrepreneur[$index] }}</td>
                             @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['individualEntrepreneurs.destroy', $individualEntrepreneur->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>




                            <a href="{{ route('individualEntrepreneurs.edit', [$individualEntrepreneur->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $individualEntrepreneurs])
        </div>
    </div>
</div>
