<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('status', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
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


<!-- Value Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('value', $word['title_value']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('value', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Change Number Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('change_number', $word['title_change_number']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('change_number', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Apply Immediately Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('apply_immediately', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('apply_immediately', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('apply_immediately', $word['title_apply_immediately'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Must Be All Products Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('must_be_all_products', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('must_be_all_products', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('must_be_all_products', $word['title_must_be_all_products'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Type Number Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type_number', $word['title_type_number']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type_number', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Min Total Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('min_total_price', $word['title_min_total_price']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('min_total_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Min Product Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('min_product_price', $word['title_min_product_price']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('min_product_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Max Total Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('max_total_price', $word['title_max_total_price']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('max_total_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Max Product Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('max_product_price', $word['title_max_product_price']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('max_product_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Apply For Products Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('apply_for_products', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('apply_for_products', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('apply_for_products', $word['title_apply_for_products'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Date Start Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_start', $word['title_date_start']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('date_start', null, ['class' => 'form-control','id'=>'date_start']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_start').datepicker()
    </script>
@endpush


<!-- Date End Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_end', $word['title_date_end']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('date_end', null, ['class' => 'form-control','id'=>'date_end']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_end').datepicker()
    </script>
@endpush
