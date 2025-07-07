<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', $word['title_name']) !!}
    <p>{{ $store->name }}</p>
</div>


<!-- Url Field -->
<div class="col-sm-12">
    {!! Form::label('url', $word['title_url']) !!}
    <p>{{ $store->url }}</p>
</div>


<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', $word['title_created_at']) !!}
    <p>{{ $store->created_at }}</p>
</div>


<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', $word['title_updated_at']) !!}
    <p>{{ $store->updated_at }}</p>
</div>


