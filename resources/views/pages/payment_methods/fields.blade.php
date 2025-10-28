<!-- Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('code', $word['title_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('code', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Minimum Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('minimum', $word['title_minimum']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('minimum', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Icon Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('icon', $word['title_icon']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('icon', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
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


<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
