<!-- Title Fields -->
<div class="col-sm-12">
    {!! Form::label('descriptions_title', $word['title_descriptions_title']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][title]", $language->id) !!}
                {!! $news->descriptions[$language->id]['title'] !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('category_id', $word['title_category_id']) !!}
    <p>{{ $news->category_id }}</p>
</div>


<!-- Author Id Field -->
<div class="col-sm-12">
    {!! Form::label('author_id', $word['title_author_id']) !!}
    <p>{{ $news->author_id }}</p>
</div>


<!-- Thumbnail Field -->
<div class="col-sm-12">
    {!! Form::label('thumbnail', $word['title_thumbnail']) !!}
    <p>{{ $news->thumbnail }}</p>
</div>


<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <p>{{ $news->sort_order }}</p>
</div>


<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $news->status }}</p>
</div>

<!-- SEO Url Field -->
<div class="col-sm-12">
    {!! Form::label('path', $word['title_path']) !!}
    <p>{{ $news->path }}</p>
</div>

<!-- Description Fields -->
<div class="col-sm-12">
    {!! Form::label('descriptions_description', $word['title_descriptions_description']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][description]", $language->id) !!}
                {!! $news->descriptions[$language->id]['description'] !!}
            </div>
        @endforeach
    </div>
</div>


<!-- Shared On Facebook Field -->
<div class="col-sm-12">
    {!! Form::label('shared_on_facebook', $word['title_shared_on_facebook']) !!}
    <p>{{ $news->shared_on_facebook }}</p>
</div>


<!-- Shared On Twitter Field -->
<div class="col-sm-12">
    {!! Form::label('shared_on_twitter', $word['title_shared_on_twitter']) !!}
    <p>{{ $news->shared_on_twitter }}</p>
</div>


<!-- Reviews Count Field -->
<div class="col-sm-12">
    {!! Form::label('reviews_count', $word['title_reviews_count']) !!}
    <p>{{ $news->reviews_count }}</p>
</div>


<!-- Reviews Rating Field -->
<div class="col-sm-12">
    {!! Form::label('reviews_rating', $word['title_reviews_rating']) !!}
    <p>{{ $news->reviews_rating }}</p>
</div>


