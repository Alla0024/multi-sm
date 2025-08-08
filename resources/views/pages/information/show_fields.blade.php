<!-- Name Fields -->
<div class="col-sm-12">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][name]", $language->id) !!}
                {!! $information->descriptions[$language->id]['name'] !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $information->status }}</p>
</div>

<!-- SEO Path Field -->
<div class="col-sm-12">
    {!! Form::label('path', $word['title_path']) !!}
    <p>{{ $information->path }}</p>
</div>

<!-- Description Fields -->
<div class="col-sm-12">
    {!! Form::label('descriptions_description', $word['title_descriptions_description']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][description]", $language->id) !!}
                {!! $information->descriptions[$language->id]['description'] !!}
            </div>
        @endforeach
    </div>
</div>

