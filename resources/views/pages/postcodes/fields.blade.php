<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
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
