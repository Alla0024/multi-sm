<!-- Location Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['location_id']['inTab'] !!}">
    {!! Form::label('location_id', $word['title_location_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('location_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Payment Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['payment']['inTab'] !!}">
    {!! Form::label('payment', $word['title_payment']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('payment', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['phone']['inTab'] !!}">
    {!! Form::label('phone', $word['title_phone']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
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
