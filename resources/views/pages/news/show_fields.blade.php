<!-- Thumbnail Field -->
<div class="col-sm-12">
    {!! Form::label('thumbnail', $word['title_thumbnail']) !!}
    <p>{{ $news->thumbnail }}</p>
</div>

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

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', $word['title_updated_at']) !!}
    <p>{{ $news->updated_at }}</p>
</div>

<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <p>{{ $news->sort_order }}</p>
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

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $news->status }}</p>
</div>

<!-- SEO Field -->
<div class="col-sm-12">
    {!! Form::label('path', $word['title_path']) !!}
    <p>{{ $news->path }}</p>
</div>

<div class="col-sm-12">
    {!! Form::label('category_id', $word['title_category_id']) !!}
    <p>{{ $news->category_id['text'] }}</p>
</div>

<div class="flex-row">
    {!! Form::label('news_categories', $word['title_news_categories']) !!}
    <ul>
        @foreach($news->news_categories as $news_category)
            <li>
                {!! $news_category['text'] !!}
            </li>
        @endforeach
    </ul>
</div>

<!-- Author Id Field -->
<div class="col-sm-12">
    {!! Form::label('author_id', $word['title_author_id']) !!}
    <p>{{$news->author_id['text']}}</p>
</div>

<!-- Description Meta Title -->
<div class="col-sm-12">
    {!! Form::label('descriptions_meta_title', $word['title_descriptions_meta_title']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][meta_title]", $language->id) !!}
                {!! $news->descriptions[$language->id]['meta_title'] !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Meta H1 -->
<div class="col-sm-12">
    {!! Form::label('descriptions_meta_h1', $word['title_descriptions_meta_h1']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][meta_h1]", $language->id) !!}
                {!! $news->descriptions[$language->id]['meta_h1'] !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Meta Description -->
<div class="col-sm-12">
    {!! Form::label('descriptions_meta_description', $word['title_descriptions_meta_description']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][meta_description]", $language->id) !!}
                {!! $news->descriptions[$language->id]['meta_description'] !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Meta Keyword -->
<div class="col-sm-12">
    {!! Form::label('descriptions_meta_keyword', $word['title_descriptions_meta_keyword']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][meta_keyword]", $language->id) !!}
                {!! $news->descriptions[$language->id]['meta_keyword'] !!}
            </div>
        @endforeach
    </div>
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

