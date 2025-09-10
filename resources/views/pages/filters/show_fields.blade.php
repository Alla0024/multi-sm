<!-- Filter Group Id Field -->
<div class="col-sm-12">
    {!! Form::label('filter_group_id', $word['title_filter_group_id']) !!}
    <p>{{ $filter->filter_group_id }}</p>
</div>


<!-- Path Field -->
<div class="col-sm-12">
    {!! Form::label('path', $word['title_path']) !!}
    <p>{{ $filter->path }}</p>
</div>


<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <p>{{ $filter->sort_order }}</p>
</div>


<!-- Default Viewed Field -->
<div class="col-sm-12">
    {!! Form::label('default_viewed', $word['title_default_viewed']) !!}
    <p>{{ $filter->default_viewed }}</p>
</div>


<!-- Parent Field -->
<div class="col-sm-12">
    {!! Form::label('parent', $word['title_parent']) !!}
    <p>{{ $filter->parent }}</p>
</div>


<!-- Parent Id Field -->
<div class="col-sm-12">
    {!! Form::label('parent_id', $word['title_parent_id']) !!}
    <p>{{ $filter->parent_id }}</p>
</div>


