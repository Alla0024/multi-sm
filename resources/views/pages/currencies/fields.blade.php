<!-- Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('code', $word['title_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('code', null, ['class' => 'form-control', 'required', 'maxlength' => 3, 'maxlength' => 3]) !!}
        </div>
    </div>
</div>


<!-- Title Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('title', $word['title_title']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('title', null, ['class' => 'form-control', 'required', 'maxlength' => 10, 'maxlength' => 10]) !!}
        </div>
    </div>
</div>


<!-- Symbol Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('symbol', $word['title_symbol']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('symbol', null, ['class' => 'form-control', 'required', 'maxlength' => 10, 'maxlength' => 10]) !!}
        </div>
    </div>
</div>


<!-- Rate Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('rate', $word['title_rate']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('rate', null, ['class' => 'form-control', 'required']) !!}
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
