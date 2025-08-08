<!-- Thumbnail Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['thumbnail']['inTab'] !!}">
    {!! Form::label('thumbnail', $word['title_thumbnail']) !!}
    {!! Form::text('thumbnail', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Title Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['title']['inTab'] !!}">
    {!! Form::label('descriptions_title', $word['title_descriptions_title']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][title]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>
<!-- Updated At Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['updated_at']['inTab'] !!}">
    {!! Form::label('updated_at', $word['title_updated_at']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::datetime('updated_at', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Reviews Count Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['reviews_count']['inTab'] !!}">
    {!! Form::label('reviews_count', $word['title_reviews_count']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('reviews_count', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Reviews Rating Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['reviews_rating']['inTab'] !!}">
    {!! Form::label('reviews_rating', $word['title_reviews_rating']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('reviews_rating', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['status']['inTab'] !!}">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('status', ['1' => $word['status_active'] , '0' => $word['status_inactive']], ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- SEO Url Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['path']['inTab'] !!}">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'required']) !!}
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
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['meta_title']['inTab'] !!}">
    {!! Form::label('descriptions_meta_title', $word['title_descriptions_meta_title']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][meta_title]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Meta H1 Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['meta_h1']['inTab'] !!}">
    {!! Form::label('descriptions_meta_h1', $word['title_descriptions_meta_h1']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][meta_h1]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Meta Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['meta_description']['inTab'] !!}">
    {!! Form::label('descriptions_meta_description', $word['title_descriptions_meta_description']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][meta_description]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Meta Keyword Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['meta_keyword']['inTab'] !!}">
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
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['title']['inTab'] !!}">
    {!! Form::label('descriptions_description', $word['title_descriptions_description']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
{{--                {!! Form::textarea("descriptions[$language->id][description]", null, ['class' => 'form-control', 'rows' => 2, 'required']) !!}--}}
                @if(isset($news))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1">{!! $news['descriptions'][$language->id]['description'] !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>
{{--@dd($news)--}}
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

@include('components.table.products_for_new', ['tab' => 'product'])
