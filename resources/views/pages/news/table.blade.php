<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="news-table">
            <thead>
            <tr>
                <form class="search-form" method="GET" action="">
                    @if(isset($fields))
                        @foreach($fields as $index => $field)
                            @if($index != 'id' && $field['inTable'])
                                <th class="">
                                    @if(isset($field['searchable']) && $field['searchable'])
                                        @if($index == 'status')
                                            <select class="" name="{{ $index }}" aria-label="{{ $word['search_'.$index] }}" aria-describedby="select-addon">
                                                <option value=""  selected hidden>{{ $word['search_'.$index] }}</option>
                                                <option value="1" @if(request($index) == '1') selected @endif>{{$word['status_1']}}</option>
                                                <option value="0" @if(request($index) == '0') selected @endif>{{$word['status_0']}}</option>
                                            </select>
                                        @else
                                            <div class="">
                                                <input type="text" name="{{ $index }}" placeholder="{{ $word['search_'.$index] }}" value="{{ request($index) }}">
                                            </div>
                                        @endif
                                    @endif
                                </th>
                            @endif
                        @endforeach
                    @endif
                    <th class="butt-action action-item">
                        <button class="btn btn-primary" type="submit" style="margin: 0 auto 6px">{{ $word['search'] }}</button>
                        <a href="{{ route('news.index') }}">{{ $word['cancel'] }}</a>
                    </th>
                </form>
            </tr>
            <tr>
                @if(isset($fields))
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
            @foreach($news as $new)
                <tr>

                    @foreach($fields as $index => $field)
                        @if($index == 'status')
                            @if($new[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                        @else
                            @if($index != 'id' && $field['inTable'])
                                <td>{{ $new[$index] }}</td>
                            @endif
                        @endif

                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['news.destroy', $new->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a
                               href="{{ $new->client_url }}"
                               target="_blank"
                               class='btn btn-default butt-show btn-xs'
                            >
                                <i class="bi bi-eye-fill fs-40"></i>
                            </a>
                            <a href="{{ route('news.edit', [$new->id]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>
                            {!! Form::button('<i class="bi bi-trash fs-20"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
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
            @include('adminlte-templates::common.paginate', ['records' => $news])
        </div>
    </div>
</div>
