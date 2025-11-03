<!-- Data create Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('product_id', 'Дата додавання') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            <input type="date" disabled value="@isset($productReview){{date("Y-m-d",strtotime($productReview['created_at']))}}@endisset">
        </div>
    </div>
</div>

<!-- Date Value Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_value', $word['title_date_value']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::datetimelocal('date_value', null, ['class' => 'form-control','id'=>'date_value']) !!}
        </div>
    </div>
</div>
@push('page_scripts')
    <script type="text/javascript">
        $('#date_value').datepicker()
    </script>
@endpush

<!-- Author Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('author', $word['title_author']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('author', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('status', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', 'Кількість глядачів', ['class' => 'form-check-label']) !!}
    <div class="form-check">
        <div class="input-block input-toggle flex">
            <div class="form-check form-switch content-switch" style="margin: 0" x-data="{check: @if(isset($productReview['type']) && $productReview['type'] == 1) true @else false @endif}">
                <input type="hidden" name="show_count_viewers" :value="+check">
                <input class="form-check-input form-check-input-reviews ignore_form checkbox-child" @change="check = !check" :checked="check" name="" type="checkbox" role="switch" id="switchCheckChecked_type">
            </div>
        </div>
    </div>
</div>

<!-- Product Id Field -->
@include('components.inputs.input_search', ['name' => 'product_id', 'value' => $product['description'] ?? [], 'url' => 'getProducts'])

<!-- Text Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('text', $word['title_text']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('text', null, ['class' => '', 'required', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>

<!-- Advantages Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('advantages', $word['title_advantages']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('advantages', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Limitations Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('limitations', $word['title_limitations']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('limitations', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>

<!-- Author Answer Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('author_answer', $word['title_author_answer']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('author_answer', ['0' => 'Оператор служби підтримки' , '1' => 'Керівник інтернет-магазину', '2' => 'Керівник служби продажу'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Answer Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('answer', $word['title_answer']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('answer', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>

<!-- Helpful Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('helpful', $word['title_helpful']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('helpful', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Unhelpful Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('unhelpful', $word['title_unhelpful']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('unhelpful', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Rating Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('rating', $word['title_rating']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('rating', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>



