<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', $word['title_code']) !!}
    <p>{{ $language->code }}</p>
</div>


<!-- Path Field -->
<div class="col-sm-12">
    {!! Form::label('path', $word['title_path']) !!}
    <p>{{ $language->path }}</p>
</div>


<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $language->status }}</p>
</div>


<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <p>{{ $language->sort_order }}</p>
</div>


