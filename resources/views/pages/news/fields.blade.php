<!-- Thumbnail Field -->
<div class="form-group col-sm-6 tab-pane image-block" data-for-tab="main" x-data="{open_butt: false}">
    {!! Form::label('thumbnail', $word['title_thumbnail']) !!}
    <div class="input-group">
        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="thumbnail" type="hidden" name="image" value="{{$news['thumbnail'] ?? ''}}">
            <img class="" src="{{isset($news['thumbnail']) && $news['thumbnail'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$news['thumbnail'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Title Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_title', $word['title_descriptions_title']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][title]", '', ['class' => '', 'rows' => 2, 'required' ]) !!}
            </div>
        @endforeach
    </div>
</div>
<!-- Updated At Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('updated_at', $word['title_updated_at']) !!}
    <div class="flex-row input">
        <div class="input-group">
            <input
                type="date"
                name="updated_at"
                value="@isset($news['updated_at']){{$news['updated_at']->format('Y-m-d')}}@else{{date('Y-m-d')}}@endisset"
                aria-label="Дата"
                aria-describedby="date-addon"
            >
        </div>
    </div>
</div>
{{--@dd($news)--}}

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', '', ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Reviews Count Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('reviews_count', $word['title_reviews_count']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('reviews_count', '', ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Reviews Rating Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('reviews_rating', $word['title_reviews_rating']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('reviews_rating', '', ['class' => 'form-control', 'required']) !!}
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

<!-- SEO Url Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path', '', ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Category Id Field -->
@include('components.inputs.input_search', ['name' => 'category_id', 'value' => $news ?? [], 'url' => 'getCategories'])

<!-- Category News Field -->
@include('components.inputs.multi_select', ['name' => 'news_categories', 'value' => $news ?? [], 'url' => 'getNewsCategories'])

<!-- Author Id Field -->
@include('components.inputs.input_search', ['name' => 'author_id', 'value' => $news ?? [], 'url' => 'getAuthors'])

<!-- Meta Title Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_meta_title', $word['title_descriptions_meta_title']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][meta_title]", '', ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Meta H1 Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_meta_h1', $word['title_descriptions_meta_h1']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][meta_h1]", '', ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Meta Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_meta_description', $word['title_descriptions_meta_description']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][meta_description]", '', ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Meta Keyword Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_meta_keyword', $word['title_descriptions_meta_keyword']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][meta_keyword]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_description', $word['title_descriptions_description']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
{{--                {!! Form::textarea("descriptions[$language->id][description]", null, ['class' => 'form-control', 'rows' => 2, 'required']) !!}--}}
                @if(isset($news))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1">{!! $news['descriptions'][$language->id]['description'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Product title Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="product">
    {!! Form::label('descriptions_products_title', $word['title_descriptions_products_title']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][products_title]", null, ['class' => '', 'required']) !!}

            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('alpine:init', ()=>{
        Alpine.data('news_fields', () => ({

        }))
    })
</script>


<!-- Products Fields -->
{{--@include('components.table.products_for_new', ['tab' => 'product'])--}}
@php
    $arrData = [
        'text' => ['type' => 'search_select', 'name' => 'Виберіть товар', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
    ]
@endphp
@include('components.table.table_items', ['inputType' => $arrData, 'data' => $news["products"] ?? [], 'name' => 'products', 'id_name' => 'item_id', 'url' => 'getProducts', 'tab' => 'product'])
