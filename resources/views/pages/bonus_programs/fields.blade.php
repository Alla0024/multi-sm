{{--@dump($bonusProgram)--}}


<!-- Hash Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_hash']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('hash', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Usage Percentage Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('usage_percentage', $word['title_usage_percentage']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('usage_percentage', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Min Total Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('min_total_price', $word['title_min_total_price']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('min_total_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Color Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('color', $word['title_color']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('color', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Started At Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('started_at', $word['title_started_at']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('started_at', null, ['class' => 'form-control','id'=>'started_at']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#started_at').datepicker()
    </script>
@endpush


<!-- Finished At Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('finished_at', $word['title_finished_at']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('finished_at', null, ['class' => 'form-control','id'=>'finished_at']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#finished_at').datepicker()
    </script>
@endpush


<!-- Priority Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('priority', $word['title_priority']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('priority', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Segments Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="segment">
    {!! Form::label('segments', 'Сегменти') !!}
    <div class="flex-row input">
        <div class="input-group input-tags">
            <select class="tag-select" name="bonus_program_to_segment[]" data-no-search="true" multiple>
                @foreach($segments as $item)
                    <option value="{{$item['id']}}" @if(isset($selectedSegmentIds) && in_array((int)$item['id'], $selectedSegmentIds)) selected @endif >{{$item['id']}} - {{$item['description']['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- Payments Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="payment">
    {!! Form::label('payment', 'Способи оплати') !!}
    <div class="flex-row input">
        <div class="input-group input-tags">
            <select class="tag-select" name="bonus_program_to_payment[]" data-no-search="true" multiple>
                @foreach($paymentMethods as $item)
                    <option value="{{$item['id']}}" @if(isset($selectedPaymentsIds) && in_array((int)$item['id'], $selectedPaymentsIds)) selected @endif >{{$item['id']}} - {{$item['description']['title']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
