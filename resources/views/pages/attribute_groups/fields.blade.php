<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", '', ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', '', ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
{{--@dump($attributeGroup)--}}
<!-- Option Value Groups Field -->
@php
    $arrData = [
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
        'name' => ['type' => 'string', 'name' => 'Назва атрибута', 'description' => true],
        'explanation' => ['type' => 'string', 'name' => 'Пояснення', 'description' => true],
    ];

    $data = $attributeGroup['attributes'] ?? [];

@endphp

@include('components.table.table_items', ['inputType' => $arrData, 'data' => $data, 'name' => 'attribute_group', 'id_name' => 'id', 'tab' => 'main'])
