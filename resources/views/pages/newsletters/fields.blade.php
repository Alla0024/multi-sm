<!-- Title Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('title', $word['title_title']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('title', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type', null, ['class' => 'form-control', 'maxlength' => 50, 'maxlength' => 50]) !!}
        </div>
    </div>
</div>


<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('image', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Viber Message Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('viber_message', $word['title_viber_message']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('viber_message', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Sms Message Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sms_message', $word['title_sms_message']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('sms_message', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Button Text Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('button_text', $word['title_button_text']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('button_text', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Button Url Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('button_url', $word['title_button_url']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('button_url', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Phones Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('phones', $word['title_phones']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('phones', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Start In Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('start_in', $word['title_start_in']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('start_in', null, ['class' => 'form-control','id'=>'start_in']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#start_in').datepicker()
    </script>
@endpush


<!-- Author Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('author', $word['title_author']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('author', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
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
