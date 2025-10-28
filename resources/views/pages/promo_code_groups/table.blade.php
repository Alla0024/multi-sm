<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="promo-code-groups-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            </thead>
            <tbody>
            @foreach($promoCodeGroups as $promoCodeGroup)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{  $promoCodeGroup['id']}}" name="input-toggle_{{ $promoCodeGroup['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{ $promoCodeGroup['id']}}">
                            </div>
                        </div>
                    </th>

                    @foreach($fields as $index => $field)
                        @if($index == 'status' && $field['inTable'])
                            @if($promoCodeGroup[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                         @elseif($index == 'image' && $field['inTable'])
                            <td><img style="width: 140px; border: 0.7px solid rgba(172, 172, 172, 0.20);" src="{{isset($promoCodeGroup[$index]) && $promoCodeGroup[$index] != '' ? 'https://i.svit-matrasiv.com.ua/images/'.$promoCodeGroup[$index] : '/images/common/no_images.png'}}" alt=""></td>
                         @else
                             @if($index != 'id' && $field['inTable'])
                                <td>{{ $promoCodeGroup[$index] }}</td>
                             @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['promoCodeGroups.destroy', $promoCodeGroup->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>




                            <a href="{{ route('promoCodeGroups.edit', [$promoCodeGroup->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $promoCodeGroups])
        </div>
    </div>
</div>
