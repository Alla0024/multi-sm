<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', $word['title_code']) !!}
    <p>{{ $currency->code }}</p>
</div>


<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', $word['title_title']) !!}
    <p>{{ $currency->title }}</p>
</div>


<!-- Symbol Field -->
<div class="col-sm-12">
    {!! Form::label('symbol', $word['title_symbol']) !!}
    <p>{{ $currency->symbol }}</p>
</div>


<!-- Rate Field -->
<div class="col-sm-12">
    {!! Form::label('rate', $word['title_rate']) !!}
    <p>{{ $currency->rate }}</p>
</div>


<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', $word['title_status']) !!}
    <p>{{ $currency->status }}</p>
</div>


