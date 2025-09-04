<form class="search-form" method="GET" action="">
    @if(isset($fields))
        <th>
            <div class="input-block input-toggle flex">
                <div class="form-check form-switch">
                    <input class="form-check-input checkbox-father" data-content="" name="input-toggle" type="checkbox" role="switch" id="switchCheckChecked">
                    <i class="bi bi-check-all"></i>
                </div>
            </div>
        </th>
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

    @if(request()->has('language_id'))
        <input type="hidden" name="language_id" value="{{ request('language_id') }}">
    @endif
    @if(request()->has('sortBy'))
        <input type="hidden" name="sortBy" value="{{ request('sortBy') }}">
    @endif
    @if(request()->has('perPage'))
        <input type="hidden" name="perPage" value="{{ request('perPage') }}">
    @endif

    <th class="butt-action action-item">
        <button class="btn btn-primary" type="submit" style="margin: 0 auto 6px">{{ $word['search'] }}</button>
        <a href="{{ route('news.index') }}">{{ $word['cancel'] }}</a>
    </th>
</form>
