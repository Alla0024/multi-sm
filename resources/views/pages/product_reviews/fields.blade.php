<!-- Product Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('product_id', $word['title_product_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('product_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Author Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('author', $word['title_author']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('author', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Text Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('text', $word['title_text']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('text', null, ['class' => '', 'required', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Advantages Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('advantages', $word['title_advantages']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('advantages', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Limitations Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('limitations', $word['title_limitations']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('limitations', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Answer Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('answer', $word['title_answer']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('answer', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Rating Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('rating', $word['title_rating']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('rating', null, ['class' => 'form-control', 'required']) !!}
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


<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('type', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Helpful Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('helpful', $word['title_helpful']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('helpful', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Unhelpful Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('unhelpful', $word['title_unhelpful']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('unhelpful', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Date Value Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_value', $word['title_date_value']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('date_value', null, ['class' => 'form-control','id'=>'date_value']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_value').datepicker()
    </script>
@endpush


<!-- Author Answer Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('author_answer', $word['title_author_answer']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('author_answer', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>
