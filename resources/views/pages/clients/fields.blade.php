<!-- Activation Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('activation', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('activation', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('activation', $word['title_activation'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Photo Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('photo', $word['title_photo']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('photo', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Surname Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('surname', $word['title_surname']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('surname', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('name', $word['title_name']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Birthday Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('birthday', $word['title_birthday']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('birthday', null, ['class' => 'form-control','id'=>'birthday']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#birthday').datepicker()
    </script>
@endpush


<!-- Email Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('email', $word['title_email']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::email('email', '', ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('phone', $word['title_phone']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- password Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('password', $word['title_password']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::password('password', ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- User Agent Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('user_agent', $word['title_user_agent']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('user_agent', null, ['class' => '', 'required', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Location Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('location_id', $word['title_location_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('location_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Address Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('address', $word['title_address']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('address', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Remember Token Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('remember_token', $word['title_remember_token']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('remember_token', null, ['class' => 'form-control', 'maxlength' => 100, 'maxlength' => 100]) !!}
        </div>
    </div>
</div>


<!-- Temporary Code Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('temporary_code', $word['title_temporary_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('temporary_code', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
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


<!-- Viber Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('viber_id', $word['title_viber_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('viber_id', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- App Token Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('app_token', $word['title_app_token']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('app_token', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Verification Phone Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('verification_phone_code', $word['title_verification_phone_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('verification_phone_code', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Verification Email Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('verification_email_code', $word['title_verification_email_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('verification_email_code', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Verified Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('verified_phone', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('verified_phone', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('verified_phone', $word['title_verified_phone'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Verified Email Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('verified_email', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('verified_email', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('verified_email', $word['title_verified_email'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Up To 1C Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('up_to_1c', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('up_to_1c', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('up_to_1c', $word['title_up_to_1c'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Updated At 1C Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('updated_at_1c', $word['title_updated_at_1c']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('updated_at_1c', null, ['class' => 'form-control','id'=>'updated_at_1c']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#updated_at_1c').datepicker()
    </script>
@endpush
