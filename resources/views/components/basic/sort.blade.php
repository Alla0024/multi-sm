{{--@foreach(request()->except('perPage', 'page') as $key => $value)--}}
{{--    <input type="hidden" name="{{ $key }}" value="{{ $value }}">--}}
{{--@endforeach--}}
    @isset($languages)
        <div style="display: flex; width: 177px; flex-shrink: 0; flex-direction: column; align-items: start; text-align: start; row-gap: 10px; margin-right: 20px">
            <label for="language_id">{{ $word['language'] }}</label>
            <select name="language_id" id="language_id" onchange="this.form.submit()">
                <option
                    value="{{$languages[1]->id}}" {{ request('language_id') == null ? 'selected' : '' }}>
                    {!! $word['select'] !!}
                </option>
                @foreach($languages as $language)
                    <option
                        value="{{ $language->id }}" {{ request('language_id') == $language->id ? 'selected' : '' }}>
                        {{$word['language_'.$language->code]}}
                    </option>
                @endforeach
            </select>
        </div>
    @endisset

    @isset($sortFields)
        <div style="display: flex; width: 177px; flex-shrink: 0; flex-direction: column; align-items: start; text-align: start; row-gap: 10px; margin-right: 20px">
            <label for="sortBy">{{ $word['sort_by'] }}</label>
            <select name="sortBy" id="sortBy" onchange="this.form.submit()">
                @foreach($sortFields as $field)
                    <option
                        value="{{ $field }}" {{ request('sortBy') == $field ? 'selected' : '' }}>
                        {{ $word['sort_'.$field] }}
                    </option>
                @endforeach
            </select>
        </div>
    @endisset
    <div style="display: flex; width: 177px; flex-shrink: 0; flex-direction: column; align-items: start; text-align: start; row-gap: 10px; margin-right: 20px">
        <label for="perPage">{{ $word['show_by'] }}</label>
        <select name="perPage" id="perPage" onchange="this.form.submit()">
            @foreach([10, 25, 50, 100] as $size)
                <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>
                    {{ $size }}
                </option>
            @endforeach
        </select>
    </div>

@php($keep = request()->except(['language_id','sortBy','perPage','page']))
@foreach($keep as $key => $value)
    @if(is_array($value))
        @foreach($value as $v)
            <input type="hidden" name="{{ $key }}[]" value="{{ e($v) }}">
        @endforeach
    @else
        <input type="hidden" name="{{ $key }}" value="{{ e($value) }}">
    @endif
@endforeach

