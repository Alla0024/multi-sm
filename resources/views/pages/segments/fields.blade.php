<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('status', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('status', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('status', $word['title_status'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Hash Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_hash']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('hash', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Product Count Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('product_count', $word['title_product_count']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('product_count', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Value Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('value', $word['title_value']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('value', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Type Number Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type_number', $word['title_type_number']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type_number', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Choose Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('choose_price', $word['title_choose_price']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('choose_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Calculation From Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('calculation_from', $word['title_calculation_from']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('calculation_from', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Show In Sale Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('show_in_sale', $word['title_show_in_sale']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('show_in_sale', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
