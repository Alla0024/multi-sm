<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', $word['title_code']) !!}
    <p>{{ $paymentMethod->code }}</p>
</div>


<!-- Minimum Field -->
<div class="col-sm-12">
    {!! Form::label('minimum', $word['title_minimum']) !!}
    <p>{{ $paymentMethod->minimum }}</p>
</div>


<!-- Icon Field -->
<div class="col-sm-12">
    {!! Form::label('icon', $word['title_icon']) !!}
    <p>{{ $paymentMethod->icon }}</p>
</div>


<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $paymentMethod->status }}</p>
</div>


<!-- Sort Order Field -->
<div class="col-sm-12">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <p>{{ $paymentMethod->sort_order }}</p>
</div>


