@dump($product)
@dump($product['options'])
@dump($options)
@dump($options[13])
@dump($stores)
{{--@dump($product['segments'])--}}

<!-- Main tab -->
@include('pages.products.tabs.main')

<!-- Data tab -->
@include('pages.products.tabs.data')

<!-- Connections tab -->
@include('pages.products.tabs.connections')

<!-- Attributes tab -->
@include('pages.products.tabs.attributes')

<!-- Images tab -->
@include('pages.products.tabs.images')

<!-- Video tab -->
@include('pages.products.tabs.video')

<!-- Options tab -->
@include('pages.products.tabs.options')

<!-- Kit tab -->
@if(isset($product['kit']))
@include('pages.products.tabs.kit')
@endif

<!-- Certificates tab -->
@include('pages.products.tabs.certificates')

<!-- Count tab -->
@include('pages.products.tabs.count')

<!-- Filling tab -->
@include('pages.products.tabs.filling')

<!-- Segment tab -->
@include('pages.products.tabs.segment')

<!-- Similar tab -->
@include('pages.products.tabs.similar')








<!-- Manufacturer Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('manufacturer_id', $word['title_manufacturer_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('manufacturer_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Category Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('category_id', $word['title_category_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('category_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Kit Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('kit_id', $word['title_kit_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('kit_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Rating Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('rating', $word['title_rating']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('rating', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Reviews Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('reviews', $word['title_reviews']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('reviews', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Location Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('location_id', $word['title_location_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('location_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Name In 1C Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('name_in_1c', $word['title_name_in_1c']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('name_in_1c', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Copy Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('copy', $word['title_copy']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('copy', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>







<!-- Mini Images Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="">
    {!! Form::label('mini_images', $word['title_mini_images']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('mini_images', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>






<!-- Cashback Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('cashback', $word['title_cashback']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('cashback', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
