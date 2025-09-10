<!-- Filter Group Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('filter_group_id', $word['title_filter_group_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('filter_group_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Default Viewed Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('default_viewed', $word['title_default_viewed']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('default_viewed', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Parent Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('parent', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('parent', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('parent', $word['title_parent'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Parent Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('parent_id', $word['title_parent_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('parent_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
