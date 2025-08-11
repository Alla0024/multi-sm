<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label($name, $word['title_'.$name]) !!}
    <div class="flex-row input">
        <div class="input-group input-tags">
            <select class="tag-select" name="{{$name}}[]" data-no-search="true" multiple>

                @foreach($value[$name] ?? [] as $item)
                    <option value="{{$item['id']}}" selected>{{$item['name']}}</option>
                @endforeach
                    <option value="1">Світ Матраців</option>
                    <option value="2">Bon Colchón</option>
                    <option value="3">Munger</option>
            </select>
        </div>
    </div>
</div>
