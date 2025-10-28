<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('status', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('status', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('status', $word['title_status'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Hidden Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hidden', $word['title_hidden']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('hidden', null, ['class' => 'form-control', 'required']) !!}
        </div>
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


<!-- Time Start Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('time_start', $word['title_time_start']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('time_start', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Time End Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('time_end', $word['title_time_end']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('time_end', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Loop Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('loop', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('loop', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('loop', $word['title_loop'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Show In Product Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('show_in_product', $word['title_show_in_product']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('show_in_product', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Show In Sale Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('show_in_sale', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('show_in_sale', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('show_in_sale', $word['title_show_in_sale'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Show More Sale Url Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('show_more_sale_url', $word['title_show_more_sale_url']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('show_more_sale_url', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Default Sale Shop Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('default_sale_shop', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('default_sale_shop', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('default_sale_shop', $word['title_default_sale_shop'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Compare Options Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('compare_options', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('compare_options', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('compare_options', $word['title_compare_options'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Has One Activator Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('has_one_activator', $word['title_has_one_activator']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('has_one_activator', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Accrue Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('accrue', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('accrue', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('accrue', $word['title_accrue'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Icon Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('icon', $word['title_icon']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('icon', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>
