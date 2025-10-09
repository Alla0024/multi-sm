<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'rows' => 2, 'required' ]) !!}
            </div>
        @endforeach
    </div>
</div>
{{--@dump($option['valueGroups'][0])--}}
<!-- Comment Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_comment', $word['title_descriptions_comment']) !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][comment]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('type', ['radio' => $word['input_radio'] , 'checkbox' => $word['input_checkbox']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::text('path', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
{{--@dump($option)--}}
<!-- Option Value Groups Field -->
@php
    $arrData = [
        'name' => ['type' => 'string', 'name' => 'Значення', 'description' => true],
        'image' => ['type' => 'image', 'name' => 'Зображення', 'description' => false],
        'css_code' => ['type' => 'string', 'name' => 'CSS код', 'description' => false],
        'meta_title' => ['type' => 'string', 'name' => 'Мета назва', 'description' => true],
        'path' => ['type' => 'string', 'name' => 'Посилання', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
    ];
@endphp

@include('components.table.table_items', ['inputType' => $arrData, 'data' => $option['valueGroups'] ?? [], 'name' => 'option_value', 'id_name' => 'id', 'tab' => 'main'])

