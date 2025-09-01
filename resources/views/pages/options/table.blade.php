<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="options-table">
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
                                        @elseif($index == 'appears_in_categories')
                                            <select class=""  name="{{ $index }}" aria-label="{{ $word['search_'.$index] }}" aria-describedby="select-addon">
                                                <option value="" @if(request($index) == null) selected @endif>{{ $word['all'] }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category['id'] }}" @if(request($index) == $category['id']) selected @endif >{{ $category['text'] }}</option>
                                                @endforeach
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
                        <span class="hide">options</span>
                        <button class="btn btn-primary" type="submit" style="margin: 0 auto 6px">{{ $word['search'] }}</button>
                        <a href="{{ route('options.index') }}">{{ $word['cancel'] }}</a>
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
            @foreach($options as $option)
                <tr>
                    @foreach($fields as $index => $field)
                        @if($index == 'status')
                            @if($option[$index] == 1)
                                <td><div class="status_active">{{ $word['status_0'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_1'] }}</div></td>
                            @endif
                        @else
                         @if($index != 'id' && $index != 'appears_in_categories' && $field['inTable'])
                            <td>{{ $option[$index] }}</td>

                         @elseif($index == 'appears_in_categories')
                             <td>
                                 <div style="
                                 display: flex;
                                 align-items: start;
                                 flex-wrap: wrap;
                                 width: 100%;
                                 max-width: 480px;
                                 height: auto;
                                 max-height: 100px;
                                 row-gap: 4px;
                                 overflow-y: auto;
                                 margin: 0 auto;
                                 ">
                                 @foreach($option[$index] as $category)
                                     <div style="
                                        background: #FBFCFCFF;
                                        padding: 2px 4px;
                                        margin: 1px 4px;
                                        height: 20px;
                                        border: 1px solid #ACACACFF;
                                        border-radius: 4px;
                                     ">{{$category}}</div>
                                 @endforeach
                                 </div>
                             </td>
                         @endif
                        @endif
                    @endforeach

                    <td  >
                        {!! Form::open(['route' => ['options.destroy', $option->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('options.edit', [$option->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $options])
        </div>
    </div>
</div>
