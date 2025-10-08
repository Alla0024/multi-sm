<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="newsletters-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            </thead>
            <tbody>
            @foreach($newsletters as $newsletter)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{  $newsletter['id']}}" name="input-toggle_{{ $newsletter['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{ $newsletter['id']}}">
                            </div>
                        </div>
                    </th>

                    @foreach($fields as $index => $field)
                        @if($index == 'status' && $field['inTable'])
                            @if($newsletter[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif

                         @elseif($index == 'image' && $field['inTable'])
                            <td><img style="width: 140px; border: 0.7px solid rgba(172, 172, 172, 0.20);" src="{{isset($newsletter[$index]) && $newsletter[$index] != '' ? 'https://i.svit-matrasiv.com.ua/images/'.$newsletter[$index] : '/images/common/no_images.png'}}" alt=""></td>
                        @elseif($index == 'type' && $field['inTable'])
                            <td>{{config('settings.message_types')[$newsletter[$index]]}}</td>
                        @else
                             @if($index != 'id' && $field['inTable'])
                                <td>{{ $newsletter[$index] }}</td>
                             @endif
                        @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['newsletters.destroy', $newsletter->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>

                            <a href="{{ route('newsletters.edit', [$newsletter->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $newsletters])
        </div>
    </div>
</div>
