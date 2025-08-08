<!-- Title Fields -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['description']['inTab'] !!}">
    {!! Form::label('descriptions_title', $word['title_descriptions_name']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][name]", $language->id, ['class' => 'form-label']) !!}
                {!! Form::textarea("descriptions[$language->id][name]", null, ['class' => 'form-control', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
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

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['description']['inTab'] !!}">
    {!! Form::label('descriptions_description', $word['title_descriptions_description']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][description]", $language->id, ['class' => 'form-label']) !!}
                {!! Form::textarea("descriptions[$language->id][description]", null, ['class' => 'form-control', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>
