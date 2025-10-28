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
            {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


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


<!-- Address Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('address', $word['title_address']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('address', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
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


<!-- Location Group Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('location_group_id', $word['title_location_group_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('location_group_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Location Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('location_id', $word['title_location_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('location_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Ref Settlement Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('ref_settlement', $word['title_ref_settlement']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('ref_settlement', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Payment Method Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('payment_method_id', $word['title_payment_method_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('payment_method_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Payment Method Comment Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('payment_method_comment', $word['title_payment_method_comment']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('payment_method_comment', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Shipping Method Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('shipping_method_id', $word['title_shipping_method_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('shipping_method_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Shipping Method Comment Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('shipping_method_comment', $word['title_shipping_method_comment']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('shipping_method_comment', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Serialized Data Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('serialized_data', $word['title_serialized_data']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('serialized_data', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Client Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('client_id', $word['title_client_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('client_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Total Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('total', $word['title_total']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('total', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Promo Sum Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('promo_sum', $word['title_promo_sum']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('promo_sum', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Order Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('order_status', $word['title_order_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('order_status', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Status From 1C Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status_from_1c', $word['title_status_from_1c']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('status_from_1c', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Order User Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('order_user_id', $word['title_order_user_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('order_user_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Lead Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('lead_id', $word['title_lead_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('lead_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Ip Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('ip', $word['title_ip']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('ip', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- User Agent Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('user_agent', $word['title_user_agent']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('user_agent', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>
