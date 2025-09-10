<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', $word['title_image']) !!}
    <p>{{ $category->image }}</p>
</div>


<!-- Full Image Field -->
<div class="col-sm-12">
    {!! Form::label('full_image', $word['title_full_image']) !!}
    <p>{{ $category->full_image }}</p>
</div>


<!-- Icon Field -->
<div class="col-sm-12">
    {!! Form::label('icon', $word['title_icon']) !!}
    <p>{{ $category->icon }}</p>
</div>


<!-- Parent Id Field -->
<div class="col-sm-12">
    {!! Form::label('parent_id', $word['title_parent_id']) !!}
    <p>{{ $category->parent_id }}</p>
</div>


<!-- Sub Field -->
<div class="col-sm-12">
    {!! Form::label('sub', $word['title_sub']) !!}
    <p>{{ $category->sub }}</p>
</div>


<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <p>{{ $category->sort_order }}</p>
</div>


<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $category->status }}</p>
</div>


