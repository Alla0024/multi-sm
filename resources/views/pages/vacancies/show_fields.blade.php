<!-- Location Id Field -->
<div class="col-sm-12">
    {!! Form::label('location_id', $word['title_location_id']) !!}
    <p>{{ $vacancy->location_id }}</p>
</div>


<!-- Payment Field -->
<div class="col-sm-12">
    {!! Form::label('payment', $word['title_payment']) !!}
    <p>{{ $vacancy->payment }}</p>
</div>


<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', $word['title_phone']) !!}
    <p>{{ $vacancy->phone }}</p>
</div>


<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $vacancy->status }}</p>
</div>


