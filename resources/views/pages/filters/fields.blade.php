

{{--@dump($filter)--}}
{{--@dump($filterGroup)--}}

{{--@dump($filterGroup[0])--}}



{{--@dump($options)--}}

{{--@dump($options[4])--}}


{{--@dump($options[0]['optionValueGroups'][0])--}}


<!-- Title name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('title_name', $word['title_name']) !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                <input type="text" required name="descriptions[{{$language->id}}][name]" value="@if(isset($filterGroup)){{$filterGroup['descriptions'][$language->id]['name']}}@endif">
            </div>
        @endforeach
    </div>
</div>

<!-- Comment Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('title_comment', $word['title_comment']) !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                <textarea name="descriptions[{{$language->id}}][comment]" rows="2" cols="50" required>@if(isset($filterGroup)){{$filterGroup['descriptions'][$language->id]['comment']}}@endif</textarea>
            </div>
        @endforeach
    </div>
</div>

<!-- Tags Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('title_meta_tags', $word['title_meta_tags']) !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                <input type="text" required name="descriptions[{{$language->id}}][meta_title]" value="@if(isset($filterGroup)){{$filterGroup['descriptions'][$language->id]['meta_title']}}@endif">
            </div>
        @endforeach
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            <select class="form-control" name="type" required id="type">
                <option value="radio" style="background: #3e60d5" @if(isset($filterGroup) && $filterGroup['type'] == 'radio') selected @endif>{{$word['input_radio']}}</option>
                <option value="checkbox" @if(isset($filterGroup) && $filterGroup['type'] == 'checkbox') selected @endif>{{$word['input_checkbox']}}</option>
            </select>
        </div>
    </div>
</div>

<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            <input class="form-control" type="text" required name="path" value="@if(isset($filterGroup)){{$filterGroup['path']}}@endif">
        </div>
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            <input class="form-control" type="number" required name="sort_order" value="@if(isset($filterGroup)){{$filterGroup['sort_order']}}@endif">
        </div>
    </div>
</div>

<!-- Option Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('option_id', $word['title_option']) !!}
    <div class="flex-row input input-min">
        <div class="input-group input-list-search" style="position: relative;">
            @isset($filterGroup['option_id'])
                <input type="hidden" name="option_id" value="{{$filterGroup['option_id']}}">
            @else
                <input type="hidden" name="option_id" value="">
            @endisset
            <input
                    class="ignore_form"
                    name="option_id"
                    placeholder="Пошук..."
                    autocomplete="off"
                    value="@if(isset($options)) {{ $options->firstWhere('description.option_id', $filterGroup['option_id'])['description']['name'] ?? ''}} @endif"
                    data-url=""
                    @input="$store.page.searchSelect($event.target)"
                    @focus="$store.page.searchSelect($event.target)"
                    custom="true"
            >
            <ul class="custom-list hide">
                @if(isset($options))
                    @foreach($options as $item)
                        <li id="{{$item['description']['option_id']}}">{{$item['description']['name']}}</li>
                    @endforeach
                @endif
            </ul>
            <div class="svg">
                <img src="/images/common/arrow_select.png" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Filter groups -->
@php

$arrData = [
        'name' => ['type' => 'string', 'name' => 'Значення', 'description' => true],
        'meta_title' => ['type' => 'string', 'name' => 'Назва для Meta-tags', 'description' => true],
        'default_viewed' => ['type' => 'switch', 'name' => 'Основний фільтр', 'description' => false],
        'path' => ['type' => 'string', 'name' => 'Посилання', 'description' => false],
        'option_value_groups' => ['type' => 'multi_select_static_filter', 'name' => 'Значення опції', 'description' => false],
        'parent' => ['type' => 'switch', 'name' => 'Основний фільтр в групі', 'description' => false],
        'parent_id' => ['type' => 'search_select_static_filter', 'name' => 'Група для фільтру', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
];

@endphp
@include('components.table.table_items', ['inputType' => $arrData, 'data' => $filters ?? [], 'dataMultiSelect' => isset($options) ? $options->firstWhere('description.option_id', $filterGroup['option_id'])['optionValueGroups'] ?? '' : '', 'name' => 'filter', 'id_name' => 'filter_id', 'tab' => 'main'])
