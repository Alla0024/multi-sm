@php
    $renderTree = function($items, $name = '', $space = '') use (&$renderTree) {

        foreach ($items as $item) {
            echo "<li id='{$item['id']}'>{$space}{$name}{$item['name']}</li>";

            if (!empty($item['children'])) {
                $name = $name . $item['name'] . ' -> ';
                $space = $space . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $renderTree($item['children'], $name, $space);
            }
        }

    };
@endphp

<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Type Material Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_type_material', $word['title_descriptions_type_material']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][type_material]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>
{{--@dump($optionValue)--}}
<!-- Parent Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('parent_id', $word['title_parent_id']) !!}
    <div class="flex-row input">
        <div class="input-group input-list-search" style="position: relative;">
            @isset($optionValue['parent_id'])
                <input type="hidden" name="parent_id" value="{{$optionValue['parent_id']}}">
            @else
                <input type="hidden" name="parent_id" value="0">
            @endisset
            <input
                class="ignore_form"
                name="parent_id"
                placeholder="Пошук..."
                autocomplete="off"
                value=""
                data-url=""
                @input="$store.page.searchSelect($event.target)"
                @focus="$store.page.searchSelect($event.target)"
                custom="true"
            >
            <ul class="custom-list hide">
                {!! $renderTree($valuesTree) !!}
            </ul>
            <div class="svg">
                <img src="/images/common/arrow_select.png" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane image-block" data-for-tab="main" x-data="{open_butt: false}">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="input-group">
        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="thumbnail" type="hidden" name="image" value="{{$optionValue['image'] ?? ''}}">
            <img class="" src="{{isset($optionValue['image']) && $optionValue['image'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$optionValue['image'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('type', $optionValueTypes, null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
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

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('status', ['1' => $word['status_active'] , '0' => $word['status_inactive']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Default Field -->

<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('default', $word['title_default']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('default', ['1' => $word['status_active'] , '0' => $word['status_inactive']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

@if(str_contains(request()->path(), 'edit'))
    <!-- Toggle Children Status Field -->
    <div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
        {!! Form::label('children_status', $word['title_children_status']) !!}
        <div class="flex-row input">
            <div class="input-group">
                {!! Form::select('children_status', [null => 'Змінити статус дочірніх елементів', true => 'Активний', false => 'Неактивний'], null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <!-- Level Field -->
    <div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
        {!! Form::label('level', $word['title_level']) !!}
        <div class="flex-row input">
            <div class="input-group">
                {!! Form::number('level', null, ['class' => 'form-control', 'required', 'disabled']) !!}
            </div>
        </div>
    </div>

@endif
