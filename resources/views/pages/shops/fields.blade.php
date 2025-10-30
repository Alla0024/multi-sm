@dump($shop)

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('status', ['0' => 'Откл' , '1' => 'Вкл'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Quarantine Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('quarantine', 'Карантин', ['class' => 'form-check-label']) !!}
    <div class="form-check">
        <div class="input-block input-toggle flex">
            <div class="form-check form-switch content-switch" style="margin: 0" x-data="{check: @if(isset($shop['quarantine']) && $shop['quarantine'] == 1) true @else false @endif}">
                <input type="hidden" name="quarantine" :value="+check">
                <input class="form-check-input ignore_form checkbox-child" @change="check = !check" :checked="check" name="" type="checkbox" role="switch" id="switchCheckChecked_quarantine">
            </div>
        </div>
    </div>
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_description', 'Опис') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][description]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', 'Назва') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Address Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_address', 'Адреса магазину') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][address]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Schedule Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_schedule', 'Графік роботи') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][schedule]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Schedule temporary Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_schedule_temporary', 'Тимчасовий графік роботи') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][schedule_temporary]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Date Start Temporary Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_start_temporary', $word['title_date_start_temporary']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::datetimelocal('date_start_temporary', null, ['class' => 'form-control','id'=>'date_start_temporary']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_start_temporary').datepicker()
    </script>
@endpush

<!-- Date End Temporary Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_end_temporary', $word['title_date_end_temporary']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::datetimelocal('date_end_temporary', null, ['class' => 'form-control','id'=>'date_end_temporary']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_end_temporary').datepicker()
    </script>
@endpush

<!-- Location Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('location_id', $word['title_location_id']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('location_id', $locations ?? '', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('phone', $word['title_phone']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Additional Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('additional_phone', $word['title_additional_phone']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('additional_phone', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Postal Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('postal_code', $word['title_postal_code']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('postal_code', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Hash Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_hash']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('hash', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Google Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('google_path', $word['title_google_path']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('google_path', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Fake Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('fake_status', $word['title_fake_status']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('fake_status', ['2' => 'Франшиза' , '1' => 'Фейковий магазин' , '0' => 'Оригінал'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Geocode Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('geocode', $word['title_geocode']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('geocode', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>





















<!-- Path Sale Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path_sale', $word['title_path_sale']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path_sale', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>








<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('image', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>





<!-- Show Form Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('show_form', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('show_form', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('show_form', $word['title_show_form'], ['class' => 'form-check-label']) !!}
    </div>
</div>









<!-- Date End Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_end', $word['title_date_end']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('date_end', null, ['class' => 'form-control','id'=>'date_end']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_end').datepicker()
    </script>
@endpush








<!-- Date Start Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_start', $word['title_date_start']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('date_start', null, ['class' => 'form-control','id'=>'date_start']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_start').datepicker()
    </script>
@endpush
