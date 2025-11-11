{{--@dump($individualEntrepreneur)--}}
{{--@dump($paymentMethods)--}}
{{--@dump($paymentMethodsIds)--}}
{{--@dump($bank)--}}

<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('name', $word['title_name']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Store Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('store_id', $word['title_store_id']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('store_id', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Store Key Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('store_key', $word['title_store_key']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('store_key', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Token Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('token', $word['title_token']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('token', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Date Start Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_start', $word['title_date_start']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::datetimelocal('date_start', null, ['class' => 'form-control','id'=>'date_start']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_start').datepicker()
    </script>
@endpush


<!-- Date End Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_end', $word['title_date_end']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::datetimelocal('date_end', null, ['class' => 'form-control','id'=>'date_end']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_end').datepicker()
    </script>
@endpush

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Bank Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', 'Банк') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            <select class="" name="bank_id"  aria-describedby="select-addon">
                @foreach($bank as $item)
                    <option value="{{$item['id']}}" @if(isset($individualEntrepreneur) && $individualEntrepreneur['bank_id'] == $item['id']) selected @endif>{{$item['descriptions'][1]['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>


<!-- Payments Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('payment', 'Оплата') !!}
    <div class="flex-row input">
        <div class="input-group input-tags">
            <select class="tag-select" name="individual_entrepreneur_to_payment[]" data-no-search="true" multiple>
                @foreach($paymentMethods as $item)
                    <option value="{{$item['id']}}" @if(isset($paymentMethodsIds) && in_array((int)$item['id'], $paymentMethodsIds)) selected @endif >{{$item['id']}} - {{$item['description']['title']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
