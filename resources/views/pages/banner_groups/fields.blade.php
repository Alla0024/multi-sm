<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('name', $word['title_name']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Type Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type_id', $word['title_type_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type_id', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Layout Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('layout', $word['title_layout']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('layout', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Width Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('width', $word['title_width']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('width', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Height Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('height', $word['title_height']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('height', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
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
