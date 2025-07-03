<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', __('models/langs.fields.code').':') !!}
    <p>{{ $lang->code }}</p>
</div>

<!-- Path Field -->
<div class="col-sm-12">
    {!! Form::label('path', __('models/langs.fields.path').':') !!}
    <p>{{ $lang->path }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', __('models/langs.fields.status').':') !!}
    <p>{{ $lang->status }}</p>
</div>

<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', __('models/langs.fields.sort_order').':') !!}
    <p>{{ $lang->sort_order }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/langs.fields.created_at').':') !!}
    <p>{{ $lang->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/langs.fields.updated_at').':') !!}
    <p>{{ $lang->updated_at }}</p>
</div>

