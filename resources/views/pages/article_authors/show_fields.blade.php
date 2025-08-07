<!-- Avatar Field -->
<div class="col-sm-12">
    {!! Form::label('avatar', $word['title_avatar']) !!}
    <p>{{ $articleAuthor->avatar }}</p>
</div>

<!-- SEO Path Field -->
<div class="col-sm-12">
    {!! Form::label('path', $word['title_path']) !!}
    <p>{{ $articleAuthor->path }}</p>
</div>

<!-- Facebook Field -->
<div class="col-sm-12">
    {!! Form::label('facebook', $word['title_facebook']) !!}
    <p>{{ $articleAuthor->facebook }}</p>
</div>

<!-- Instagram Field -->
<div class="col-sm-12">
    {!! Form::label('instagram', $word['title_instagram']) !!}
    <p>{{ $articleAuthor->instagram }}</p>
</div>

<!-- Name Fields -->
<div class="col-sm-12">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][name]", $language->id) !!}
                {!! $articleAuthor->descriptions[$language->id]['name'] !!}
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
                {!! $articleAuthor->descriptions[$language->id]['description'] !!}
            </div>
        @endforeach
    </div>
</div>



