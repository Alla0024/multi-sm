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


<!-- Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('code', $word['title_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('code', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
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


<!-- Type Number Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type_number', $word['title_type_number']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type_number', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Promo Code Group Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('promo_code_group_id', $word['title_promo_code_group_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('promo_code_group_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Number Of Uses Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('number_of_uses', $word['title_number_of_uses']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('number_of_uses', null, ['class' => 'form-control', 'required']) !!}
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
