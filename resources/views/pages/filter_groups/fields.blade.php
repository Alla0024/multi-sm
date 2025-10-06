

@dump($filter)
@dump($filterGroup)

{{--@dump($filterGroup[0])--}}



{{--@dump($options)--}}

{{--@dump($options[4])--}}


{{--@dump($options[0]['optionValueGroups'][0])--}}


<!-- Title name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('title_name', $word['title_name']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['required' ]) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Comment Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('title_comment', $word['title_comment']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][comment]", null, ['class' => '', 'rows' => 2, 'required' ]) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Tags Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('title_meta_tags', $word['title_meta_tags']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][meta_title]", null, ['required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('type', ['radio' => $word['input_radio'] , 'checkbox' => $word['input_checkbox']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Option Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('option_id', $word['title_option']) !!}
    <div class="flex-row input">
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
                    value="{{$options->firstWhere('description.option_id', $filterGroup['option_id'])['description']['name'] ?? ''}}"
                    data-url=""
                    @input="$store.page.searchSelect($event.target)"
                    @focus="$store.page.searchSelect($event.target)"
                    custom="true"
            >
            <ul class="custom-list hide">
                @foreach($options as $item)
                    <li id="{{$item['description']['option_id']}}">{{$item['description']['name']}}</li>
                @endforeach
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
@include('components.table.table_items', ['inputType' => $arrData, 'data' => $filter ?? [], 'dataMultiSelect' => $options->firstWhere('description.option_id', $filterGroup['option_id'])['optionValueGroups'] ?? '', 'name' => 'filter', 'id_name' => 'filter_id', 'tab' => 'main'])
