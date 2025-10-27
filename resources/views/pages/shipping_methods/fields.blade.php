<!-- Minimum Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('minimum', $word['title_minimum']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('minimum', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Maximum Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('maximum', $word['title_maximum']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('maximum', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Depend Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('depend', $word['title_depend']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('depend', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
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


<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type', null, ['class' => 'form-control', 'maxlength' => 15, 'maxlength' => 15]) !!}
        </div>
    </div>
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('status', null, ['class' => 'form-control', 'required']) !!}
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


<!-- Start Date Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('start_date', $word['title_start_date']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#start_date').datepicker()
    </script>
@endpush


<!-- End Date Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('end_date', $word['title_end_date']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#end_date').datepicker()
    </script>
@endpush
