<!-- Category Id Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['category_id']['inTab'] !!}">
    {!! Form::label('category_id', $word['title_category_id']) !!}
    {!! Form::number('category_id', null, ['class' => 'form-control']) !!}
</div>


<!-- Author Id Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['author_id']['inTab'] !!}">
    {!! Form::label('author_id', $word['title_author_id']) !!}
    {!! Form::number('author_id', null, ['class' => 'form-control']) !!}
</div>


<!-- Thumbnail Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['thumbnail']['inTab'] !!}">
    {!! Form::label('thumbnail', $word['title_thumbnail']) !!}
    {!! Form::text('thumbnail', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>


<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['status']['inTab'] !!}">
    {!! Form::label('status', $word['title_status']) !!}
    {!! Form::number('status', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- SEO Url Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['path']['inTab'] !!}">
    {!! Form::label('path', $word['title_path']) !!}
    {!! Form::text('path', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Shared On Facebook Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['shared_on_facebook']['inTab'] !!}">
    {!! Form::label('shared_on_facebook', $word['title_shared_on_facebook']) !!}
    {!! Form::number('shared_on_facebook', null, ['class' => 'form-control']) !!}
</div>


<!-- Shared On Twitter Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['shared_on_twitter']['inTab'] !!}">
    {!! Form::label('shared_on_twitter', $word['title_shared_on_twitter']) !!}
    {!! Form::number('shared_on_twitter', null, ['class' => 'form-control']) !!}
</div>


<!-- Reviews Count Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['reviews_count']['inTab'] !!}">
    {!! Form::label('reviews_count', $word['title_reviews_count']) !!}
    {!! Form::number('reviews_count', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Reviews Rating Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['reviews_rating']['inTab'] !!}">
    {!! Form::label('reviews_rating', $word['title_reviews_rating']) !!}
    {!! Form::number('reviews_rating', null, ['class' => 'form-control', 'required']) !!}
</div>
