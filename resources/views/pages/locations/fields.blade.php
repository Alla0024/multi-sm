<!-- Location Group Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('location_group_id', $word['title_location_group_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('location_group_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type', null, ['class' => 'form-control', 'required', 'maxlength' => 50, 'maxlength' => 50]) !!}
        </div>
    </div>
</div>


<!-- Geocode Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('geocode', $word['title_geocode']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('geocode', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Isocode Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('isocode', $word['title_isocode']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('isocode', null, ['class' => 'form-control', 'required', 'maxlength' => 15, 'maxlength' => 15]) !!}
        </div>
    </div>
</div>


<!-- Hash Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_hash']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('hash', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Ref Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('ref', $word['title_ref']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('ref', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Indexing Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('indexing', $word['title_indexing']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('indexing', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('status', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Delivery File Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('delivery_file', $word['title_delivery_file']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('delivery_file', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>
