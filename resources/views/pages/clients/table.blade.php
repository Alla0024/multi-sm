<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="clients-table">
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
            @foreach($clients as $client)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{  $client['id']}}" name="input-toggle_{{ $client['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{ $client['id']}}">
                            </div>
                        </div>
                    </th>

                    @foreach($fields as $index => $field)
                        @if($index == 'status' && $field['inTable'])
                            @if($client[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                         @elseif($index == 'image' && $field['inTable'])
                            <td><img style="width: 100px;" src="{{isset($client[$index]) && $client[$index] != '' ? 'https://i.svit-matrasiv.com.ua/images/'.$client[$index] : '/images/common/no_images.png'}}" alt=""></td>
                         @else
                             @if($index != 'id' && $field['inTable'])
                                <td>{{ $client[$index] }}</td>
                             @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>




                            <a href="{{ route('clients.edit', [$client->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $clients])
        </div>
    </div>
</div>
