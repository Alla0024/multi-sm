<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('status', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('status', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('status', $word['title_status'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Postcode Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('postcode', $word['title_postcode']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('postcode', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- City Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('city_id', $word['title_city_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('city_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Province Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('province_id', $word['title_province_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('province_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Municipality Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('municipality_id', $word['title_municipality_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('municipality_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
