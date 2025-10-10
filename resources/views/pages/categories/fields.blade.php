{{--@dump($category)--}}
{{--@dump($category['top_sale'])--}}
{{--@dump($category['attributes'])--}}
{{--@dump($activeCategories[1])--}}
{{--@dump($categories)--}}
@dump($filters)

<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sub', $word['title_name']) !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => 'form-control']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Seo-url Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sub', $word['title_path']) !!}
    <div class="flex-row input">
         <div class="input-group input-min">
             {!! Form::text("path", null, ['class' => 'form-control', 'name' => 'seo_url']) !!}
         </div>
    </div>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['1' => $word['status_active'] , '0' => $word['status_inactive']], null, ['class' => 'form-control', 'required']) !!}
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

<!-- Tag Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sub', $word['title_tag']) !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][tag]", null, ['class' => 'form-control']) !!}
            </div>
        @endforeach
    </div>
</div>

<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="filter">
    <div class="item-list-block">
        @foreach($filters as $key => $filter)
            <div class="list" x-data="{hide: true}">
                <div class="name-list" @click="hide = !hide">
                    {{ $key }}
                </div>
                <div class="list-item hide" :class="{'hide': hide}">
                    @foreach($filter as $item)
                        <div class="item">
                            <input type="hidden" disabled id="{{ $item['filter_group_id'] }}-{{ $item['id'] }}" name="filter[]" />
                            <div class="check-input">

                            </div>
                            <div class="name-item">
                                {{ $item['name'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>



@php
    $arrData = [
        'product_id' => ['type' => 'search_select_categories', 'name' => 'Виберіть товар', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
        'image' => ['type' => 'image', 'name' => 'Зображення', 'description' => false],
    ];
@endphp
@include('components.table.table_items', ['inputType' => $arrData, 'data' => $category['top_sale'] ?? [], 'name' => 'top__sale', 'id_name' => 'id', 'url' => 'getProducts', 'tab' => 'top'])

