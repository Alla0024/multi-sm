<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $postcode->status }}</p>
</div>


<!-- Postcode Field -->
<div class="col-sm-12">
    {!! Form::label('postcode', $word['title_postcode']) !!}
    <p>{{ $postcode->postcode }}</p>
</div>


<!-- City Id Field -->
<div class="col-sm-12">
    {!! Form::label('city_id', $word['title_city_id']) !!}
    <p>{{ $postcode->city_id }}</p>
</div>


<!-- Province Id Field -->
<div class="col-sm-12">
    {!! Form::label('province_id', $word['title_province_id']) !!}
    <p>{{ $postcode->province_id }}</p>
</div>


<!-- Municipality Id Field -->
<div class="col-sm-12">
    {!! Form::label('municipality_id', $word['title_municipality_id']) !!}
    <p>{{ $postcode->municipality_id }}</p>
</div>


