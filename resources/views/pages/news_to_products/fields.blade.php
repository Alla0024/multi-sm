<!-- Product Id Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['product_id']['inTab'] !!}">
    {!! Form::label('product_id', $word['title_product_id']) !!}
    {!! Form::number('product_id', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
</div>
