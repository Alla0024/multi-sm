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

<!-- Show Blocks Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['show_blocks']['inTab'] !!}">
    <div class="form-check">
        {!! Form::hidden('show_blocks', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('show_blocks', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('show_blocks', $word['title_show_blocks'], ['class' => 'form-check-label']) !!}
    </div>
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
