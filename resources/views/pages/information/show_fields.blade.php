<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <p>{{ $information->sort_order }}</p>
</div>


<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $information->status }}</p>
</div>


<!-- Show Blocks Field -->
<div class="col-sm-12">
    {!! Form::label('show_blocks', $word['title_show_blocks']) !!}
    <p>{{ $information->show_blocks }}</p>
</div>


