<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields[$name]['inTab'] !!}">
    {!! Form::label($name, $word['title_'.$name]) !!}
    <div class="flex-row input">
        <div class="input-group input-list-search" style="position: relative;">
            @isset($value)
                <input type="hidden" name="category_id" value="{{$value[$name]}}">
            @else
                <input type="hidden" name="category_id" value="{{$value[$name]}}">
            @endisset
            <input
                class="ignore_form"
                name="category_id"
                placeholder="Type to search..."
                autocomplete="off"
                value="{{$value[$name] ?? ''}}"
                data-url="{{route($url)}}"
            >
            <ul class="custom-list hide">
            </ul>
        </div>
    </div>
</div>
