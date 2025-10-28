<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('name', $word['title_name']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('phone', $word['title_phone']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('phone', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Product Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('product_id', $word['title_product_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('product_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Comment Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('comment', $word['title_comment']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('comment', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Notification Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('notification_status', $word['title_notification_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('notification_status', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Notification User Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('notification_user_id', $word['title_notification_user_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('notification_user_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Client Ip Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('client_ip', $word['title_client_ip']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('client_ip', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Client User Agent Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('client_user_agent', $word['title_client_user_agent']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('client_user_agent', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>
