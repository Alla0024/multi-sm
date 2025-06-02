<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control', 'required']) !!}
</div>


<div class="form-group col-sm-12">
    <input name="created_at" type="hidden" value="">
</div>


<div class="form-group col-sm-12">
    <input name="updated_at" type="hidden" value="">
</div>
