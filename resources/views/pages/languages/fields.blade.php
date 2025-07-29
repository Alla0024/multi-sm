<!-- Code Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['code']['inTab'] !!}">
    {!! Form::label('code', $word['title_code']) !!}
    {!! Form::text('code', null, ['class' => 'form-control', 'required', 'maxlength' => 5]) !!}
</div>


<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['path']['inTab'] !!}">
    {!! Form::label('path', $word['title_path']) !!}
    {!! Form::text('path', null, ['class' => 'form-control', 'maxlength' => 5]) !!}
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['status']['inTab'] !!}">
    <div class="form-check">
        {!! Form::hidden('status', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('status', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('status', $word['title_status'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
</div>
