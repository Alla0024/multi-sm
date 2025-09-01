<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
