{{--@dump($shop)--}}

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

<!-- Images Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('image', 'Маленьке зображення (322X242)') !!}
    <div class="flex-row input lang-block">
        <div class="input-group image-block mt-3" x-data="{open_butt: false}">
            <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                <input id="thumbnail_image" type="hidden" name="image" value="{{$shop['image'] ?? ''}}">
                <img class="" src="{{isset($shop['image']) && $shop['image'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$shop['image'] : '/images/common/no_images.png'}}" id="holder_image" alt="Прев’ю" style="max-width: 200px;">
                <div class="butt hide" :class="{'show': open_butt}">
                    <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail_image" data-preview="holder_image" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                    <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>






<!-- Images main Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="images">
    {!! Form::label('image_main', 'Основне зображення сторінки магазину (1500X640)') !!}
    <div class="flex-row input lang-block">
        <div class="input-group image-block mt-3" x-data="{open_butt: false}">
            <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                <input type="hidden" name="images[0][sort_order]" value="0">
                <input id="thumbnail_image_main" type="hidden" name="images[0][image]" value="{{$shop['image'] ?? ''}}">
                <img class="" src="{{isset($shop['shopImages'][0]['image']) && $shop['shopImages'][0]['image'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$shop['shopImages'][0]['image'] : '/images/common/no_images.png'}}" id="holder_image_main" alt="Прев’ю" style="max-width: 200px;">
                <div class="butt hide" :class="{'show': open_butt}">
                    <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail_image_main" data-preview="holder_image_main" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                    <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $arrData = [
        'image' => ['type' => 'image', 'name' => 'Зображення', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
    ];
    $img =[];
    if(isset($shop['shopImages'])){
        $img = $shop['shopImages'];
        $img[0] = [];
    }
@endphp

@include('components.table.table_items', ['inputType' => $arrData, 'data' => $img ?? [], 'search_select_type' => 'def', 'name' => 'images', 'id_name' => 'id', 'tab' => 'images', 'parse' => false])





<!-- Images banner Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="open">
    {!! Form::label('images_banner', 'Зображення') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group image-block mt-3" x-data="{open_butt: false}">
                <span class="input-group-text"  id="basic-addon1">{!! $word[$language->id] !!}</span>
                <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                    <input id="thumbnail_images_banner_{{$language->id}}" type="hidden" name="descriptions[{{$language->id}}][image_banner]" value="{{$shop['descriptions'][$language->id]['image_banner'] ?? ''}}">
                    <img class="" src="{{isset($shop['descriptions'][$language->id]['image_banner']) && $shop['descriptions'][$language->id]['image_banner'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$shop['descriptions'][$language->id]['image_banner'] : '/images/common/no_images.png'}}" id="holder_images_banner_{{$language->id}}" alt="Прев’ю" style="max-width: 200px;">
                    <div class="butt hide" :class="{'show': open_butt}">
                        <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail_images_banner_{{$language->id}}" data-preview="holder_images_banner_{{$language->id}}" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                        <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Path Sale Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="open">
    {!! Form::label('path_sale', $word['title_path_sale']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path_sale', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Show form Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="open">
    {!! Form::label('show_form', 'Карантин', ['class' => 'form-check-label']) !!}
    <div class="form-check">
        <div class="input-block input-toggle flex">
            <div class="form-check form-switch content-switch" style="margin: 0" x-data="{check: @if(isset($shop['show_form']) && $shop['show_form'] == 1) true @else false @endif}">
                <input type="hidden" name="show_form" :value="+check">
                <input class="form-check-input ignore_form checkbox-child" @change="check = !check" :checked="check" name="" type="checkbox" role="switch" id="switchCheckChecked_quarantine">
            </div>
        </div>
    </div>
</div>

<!-- Sale Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="open">
    {!! Form::label('descriptions_sale', 'Опис знижки') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][sale]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Date Start Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="open">
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
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="open">
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


