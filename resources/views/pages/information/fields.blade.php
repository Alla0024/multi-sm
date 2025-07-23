<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['status']['inTab'] !!}">
    {!! Form::label('status', $word['title_status']) !!}
    {!! Form::number('status', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Show Blocks Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['show_blocks']['inTab'] !!}">
    <div class="form-check">
        {!! Form::hidden('show_blocks', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('show_blocks', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('show_blocks', $word['title_show_blocks'], ['class' => 'form-check-label']) !!}
    </div>
</div>
