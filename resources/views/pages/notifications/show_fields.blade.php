<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', $word['title_type']) !!}
    <p>{{ $notification->type }}</p>
</div>


<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', $word['title_name']) !!}
    <p>{{ $notification->name }}</p>
</div>


<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', $word['title_phone']) !!}
    <p>{{ $notification->phone }}</p>
</div>


<!-- Product Id Field -->
<div class="col-sm-12">
    {!! Form::label('product_id', $word['title_product_id']) !!}
    <p>{{ $notification->product_id }}</p>
</div>


<!-- Comment Field -->
<div class="col-sm-12">
    {!! Form::label('comment', $word['title_comment']) !!}
    <p>{{ $notification->comment }}</p>
</div>


<!-- Notification Status Field -->
<div class="col-sm-12">
    {!! Form::label('notification_status', $word['title_notification_status']) !!}
    <p>{{ $notification->notification_status }}</p>
</div>


<!-- Notification User Id Field -->
<div class="col-sm-12">
    {!! Form::label('notification_user_id', $word['title_notification_user_id']) !!}
    <p>{{ $notification->notification_user_id }}</p>
</div>


<!-- Client Ip Field -->
<div class="col-sm-12">
    {!! Form::label('client_ip', $word['title_client_ip']) !!}
    <p>{{ $notification->client_ip }}</p>
</div>


<!-- Client User Agent Field -->
<div class="col-sm-12">
    {!! Form::label('client_user_agent', $word['title_client_user_agent']) !!}
    <p>{{ $notification->client_user_agent }}</p>
</div>


