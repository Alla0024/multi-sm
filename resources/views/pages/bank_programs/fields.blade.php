<!-- Mark Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('mark', $word['title_mark']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('mark', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Bank Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('bank_id', $word['title_bank_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('bank_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Logo Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('logo', $word['title_logo']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('logo', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Min Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('min', $word['title_min']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('min', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Max Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('max', $word['title_max']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('max', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Step Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('step', $word['title_step']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('step', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Value Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('value', $word['title_value']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('value', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Month Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('month', $word['title_month']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('month', null, ['class' => 'form-control', 'required']) !!}
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
