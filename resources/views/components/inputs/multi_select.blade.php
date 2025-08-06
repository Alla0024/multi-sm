<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('news_categories', $word['title_'.$name]) !!}
    <div class="flex-row input">
        <div class="input-group input-tags">
            <select class="tag-select" name="news_categories[]" data-no-search="true" multiple data-url="{{route('getNewsCategories')}}">
                @foreach($value[$name] ?? [] as $item)
                    <option value="{{$item['id']}}" selected>{{$item['text']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
