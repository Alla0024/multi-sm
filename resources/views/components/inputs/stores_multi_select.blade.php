<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label($name, 'Магазини') !!}
    <div class="flex-row input">
        <div class="input-group input-tags">
            <select class="tag-select" name="{{$name}}[]" data-no-search="true" multiple>

                @foreach($value[$name] ?? [] as $item)
                    <option value="{{$item['id']}}" selected>{{$item['name']}}</option>
                @endforeach
                    @foreach($stores as $item)
                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                    @endforeach
            </select>
        </div>
    </div>
</div>
