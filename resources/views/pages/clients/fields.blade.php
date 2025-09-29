<!-- Activation Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('activation', $word['title_activation']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('activation', ['1' => $word['status_activation'] , '0' => $word['status_inactivation']], null, ['class' => 'form-control', 'required', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Photo Field -->
<div class="form-group col-sm-6 tab-pane image-block" data-for-tab="main" x-data="{open_butt: false}">
    {!! Form::label('photo', $word['title_photo']) !!}
    <div class="input-group">
        <div class="custom-file image-upload" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="thumbnail" type="hidden" name="photo" value="{{$client['image'] ?? ''}}">
            <img class="" src="{{isset($client['photo']) && $client['photo'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$client['photo'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path="/catalog/category/logo_wtm"><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
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
            {!! Form::datetimelocal('birthday', null, ['class' => 'form-control','id'=>'birthday', 'disabled']) !!}
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
            {!! Form::email('email', '', ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('phone', $word['title_phone']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- password Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('password', $word['title_password']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::password('password', ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- User Agent Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('user_agent', $word['title_user_agent']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('user_agent', null, ['class' => '', 'required', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Location Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('location_id', $word['title_location_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('location_id', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Address Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('address', $word['title_address']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('address', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Remember Token Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('remember_token', $word['title_remember_token']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('remember_token', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Temporary Code Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('temporary_code', $word['title_temporary_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('temporary_code', null, ['class' => '', 'disabled', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Hash Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_hash']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('hash', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Viber Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('viber_id', $word['title_viber_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('viber_id', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- App Token Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('app_token', $word['title_app_token']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('app_token', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Verification Phone Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('verification_phone_code', $word['title_verification_phone_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('verification_phone_code', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Verification Email Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('verification_email_code', $word['title_verification_email_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('verification_email_code', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Verified Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('verified_phone', $word['title_verified_phone']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('verified_phone', ['1' => $word['status_confirm'] , '0' => $word['status_not_confirm']], null, ['class' => 'form-control', 'required', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Verified Email Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('verified_email', $word['title_verified_email']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('verified_email', ['1' => $word['status_confirm'] , '0' => $word['status_not_confirm']], null, ['class' => 'form-control', 'required', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Up To 1C Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('up_to_1c', $word['title_up_to_1c']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('up_to_1c', ['1' => $word['status_activation'] , '0' => $word['status_inactivation']], null, ['class' => 'form-control', 'required', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Updated At 1C Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('updated_at_1c', $word['title_updated_at_1c']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::datetimelocal('updated_at_1c', null, ['class' => 'form-control','id'=>'updated_at_1c', 'disabled']) !!}
        </div>
    </div>
</div>


@push('page_scripts')
    <script type="text/javascript">
        $('#updated_at_1c').datepicker()
    </script>
@endpush
