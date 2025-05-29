<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control', 'required', 'maxlength' => 5]) !!}
</div>

<!-- Path Field -->
<div class="form-group col-sm-6">
    {!! Form::label('path', 'Path:') !!}
    {!! Form::text('path', null, ['class' => 'form-control', 'maxlength' => 5]) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('status', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('status', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('status', 'Status', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sort_order', 'Sort Order:') !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
</div>
