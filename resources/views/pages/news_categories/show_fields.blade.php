<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $newsCategory->status }}</p>
</div>


<!-- Seo Url Field -->
<div class="col-sm-12">
    {!! Form::label('seo_url', $word['title_seo_url']) !!}
    <p>{{ $newsCategory->seo_url }}</p>
</div>


<!-- Color Field -->
<div class="col-sm-12">
    {!! Form::label('color', $word['title_color']) !!}
    <p>{{ $newsCategory->color }}</p>
</div>


<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <p>{{ $newsCategory->sort_order }}</p>
</div>


