<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Key Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['key']['inTab'] !!}">
    {!! Form::label('key', $word['title_key']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('key', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>
