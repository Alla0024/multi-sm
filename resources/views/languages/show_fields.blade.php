<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', 'Code:') !!}
    <p>{{ $language->code }}</p>
</div>

<!-- Path Field -->
<div class="col-sm-12">
    {!! Form::label('path', 'Path:') !!}
    <p>{{ $language->path }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $language->status }}</p>
</div>

<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', 'Sort Order:') !!}
    <p>{{ $language->sort_order }}</p>
</div>

