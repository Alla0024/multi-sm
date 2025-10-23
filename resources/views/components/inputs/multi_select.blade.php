<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{{$tab ?? 'main'}}">
    {!! Form::label($name_input, $word['title_'.$name]) !!}
    <div class="flex-row input">
        <div class="input-group input-tags">
            <select class="tag-select" name="{{$name_input}}" data-no-search="true" multiple data-url="{{route($url)}}">
                @foreach($value[$name] ?? [] as $item)
                    <option value="{{isset($second_id) ? $item[$second_id] . '-' . $item[$id_name ?? 'id'] : $item[$id_name ?? 'id']}}" selected>{{$item['text'] ?? $item['name'] ?? $item['description']['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
