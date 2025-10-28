<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="shops-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            </thead>
            <tbody>
            @foreach($shops as $shop)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{  $shop['id']}}" name="input-toggle_{{ $shop['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{ $shop['id']}}">
                            </div>
                        </div>
                    </th>

                    @foreach($fields as $index => $field)
                        @if($index == 'status' && $field['inTable'])
                            @if($shop[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                        @elseif($index == 'image' && $field['inTable'])
                            <td><img style="width: 140px; border: 0.7px solid rgba(172, 172, 172, 0.20);" src="{{isset($shop[$index]) && $shop[$index] != '' ? 'https://i.svit-matrasiv.com.ua/images/'.$shop[$index] : '/images/common/no_images.png'}}" alt=""></td>
                        @elseif($index == 'address' && $field['inTable'])
                            <td>{{ $shop['descriptions'][0]['address'] }}</td>
                        @elseif($index == 'fake_status' && $field['inTable'])
                            <td>
                                @if($shop[$index] == '0')
                                    Оригинал
                                @elseif($shop[$index] == '1')
                                    Фейковый магаз
                                @elseif($shop[$index] == '2')
                                    Франшиза
                                @endif
                            </td>
                        @else
                             @if($index != 'id' && $field['inTable'])
                                <td>{{ $shop[$index] }}</td>
                             @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['shops.destroy', $shop->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>




                            <a href="{{ route('shops.edit', [$shop->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $shops])
        </div>
    </div>
</div>
