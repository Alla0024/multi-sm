<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields[$name]['inTab'] !!}">
    {!! Form::label($name, $word['title_'.$name]) !!}
    <div class="flex-row input">
        <div class="input-group input-list-search" style="position: relative;">
            @isset($value[$name])
                <input type="hidden" name="{{$name}}" value="{{$value[$name]['id']}}">
            @else
                <input type="hidden" name="{{$name}}" value="">
            @endisset
            <input
                class="ignore_form"
                name="{{$name}}"
                placeholder="Пошук..."
                autocomplete="off"
                value="{{$value[$name]['text'] ?? ''}}"
                data-url="@isset($url){{route($url)}}@endisset"
                @input="$store.page.searchSelect($event.target)"
                @focus="$store.page.searchSelect($event.target)"
                custom="true"
            >
            <ul class="custom-list hide">

            </ul>
            <div class="svg">
                <img src="/images/common/arrow_select.png" alt="">
            </div>
        </div>
    </div>
</div>
