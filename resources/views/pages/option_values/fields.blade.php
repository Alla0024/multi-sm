<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['name']['inTab'] !!}">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][name]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Type Material Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['type_material']['inTab'] !!}">
    {!! Form::label('descriptions_type_material', $word['title_descriptions_type_material']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][type_material]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Parent Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['parent_id']['inTab'] !!}">
    {!! Form::label('parent_id', $word['title_parent_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('parent_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['image']['inTab'] !!}">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('image', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['type']['inTab'] !!}">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
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

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['status']['inTab'] !!}">
    <div class="form-check">
        {!! Form::hidden('status', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('status', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('status', $word['title_status'], ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Default Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['default']['inTab'] !!}">
    {!! Form::label('default', $word['title_default']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('default', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Level Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['level']['inTab'] !!}">
    {!! Form::label('level', $word['title_level']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('level', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
