{{--@dump($category)--}}
{{--@dump($category['top_sale'])--}}
{{--@dump($category['attributes'])--}}
{{--@dump($category['news'])--}}
{{--@dump($activeCategories[1])--}}
{{--@dump($categories)--}}
{{--@dump($filters['Розмір'])--}}

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

<!-- Filter Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="filter">
    <div class="item-list-block">
        @foreach($filters as $key => $filter)
            <div class="list" x-data="{hide: true}">
                <div class="name-list" @click="hide = !hide">
                    {{ $key }}
                </div>
                <div class="list-item hide" :class="{'hide': hide}">
                    @foreach($filter as $item)
                        <div class="item" x-data="{active: {{count($item['categories']) > 0 ? 'true' : 'false'}}}" @click="active = !active">
                            <input type="hidden" :disabled="!active" id="{{ $item['filter_group_id'] }}-{{ $item['id'] }}" value="{{ $item['filter_group_id'] }}-{{ $item['id'] }}" name="filter[]" />
                            <div class="check-input">
                                <svg class="hide" :class="{'hide': !active}" xmlns="http://www.w3.org/2000/svg" width="21" height="16" viewBox="0 0 21 16" fill="none">
                                    <path d="M20.6804 1.06868C20.634 0.956942 20.5661 0.855429 20.4806 0.769946C20.3951 0.684369 20.2936 0.616479 20.1818 0.570159C20.0701 0.52384 19.9503 0.5 19.8294 0.5C19.7084 0.5 19.5886 0.52384 19.4769 0.570159C19.3652 0.616479 19.2636 0.684369 19.1782 0.769946L6.94346 13.0047L2.07213 8.13332C1.89942 7.96061 1.66518 7.86358 1.42093 7.86358C1.17669 7.86358 0.942444 7.96061 0.769736 8.13332C0.597027 8.30603 0.5 8.54027 0.5 8.78452C0.5 9.02876 0.597027 9.26301 0.769736 9.43571L6.29227 14.9582C6.37775 15.0438 6.47926 15.1117 6.591 15.158C6.70274 15.2044 6.82251 15.2282 6.94346 15.2282C7.06442 15.2282 7.18419 15.2044 7.29593 15.158C7.40767 15.1117 7.50918 15.0438 7.59466 14.9582L20.4806 2.07234C20.5661 1.98686 20.634 1.88535 20.6804 1.77361C20.7267 1.66187 20.7505 1.5421 20.7505 1.42114C20.7505 1.30019 20.7267 1.18042 20.6804 1.06868Z" fill="#0073BE"/>
                                </svg>
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
    $arrDataTop = [
        'product_id' => ['type' => 'search_select_categories', 'name' => 'Виберіть товар', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
        'image' => ['type' => 'image', 'name' => 'Зображення', 'description' => false],
    ];
@endphp

@include('components.table.table_items', ['inputType' => $arrDataTop, 'data' => $category['top_sale'] ?? [], 'search_select_type' => 'product_id', 'name' => 'top__sale', 'id_name' => 'id', 'url' => 'getProducts', 'tab' => 'top', 'parse' => true])

@php
    $arrDataAttribute = [
        'id' => ['type' => 'search_select_categories', 'name' => 'Виберіть атрибут', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
    ];
@endphp
@include('components.table.table_items', ['inputType' => $arrDataAttribute, 'data' => $category['attributes'] ?? [], 'search_select_type' => 'attribute_id', 'name' => 'attributes', 'id_name' => 'id', 'url' => 'getAttributes', 'tab' => 'attribute', 'parse' => true])

@php
    $arrDataNews = [
        'id' => ['type' => 'search_select_categories', 'name' => 'Виберіть атрибут', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
    ];
@endphp
@include('components.table.table_items', ['inputType' => $arrDataNews, 'data' => $category['news'] ?? [], 'search_select_type' => 'new_id', 'name' => 'news', 'id_name' => 'id', 'url' => 'get_news', 'tab' => 'news', 'parse' => true])
