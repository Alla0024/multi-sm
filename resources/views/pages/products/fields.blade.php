@dump($product)
@dump($product['productAttributes'])

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




<!-- Viewers Number From Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('viewers_number_from', $word['title_viewers_number_from']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('viewers_number_from', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Viewers Number To Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('viewers_number_to', $word['title_viewers_number_to']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('viewers_number_to', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Show In Stock Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    <div class="form-check">
        {!! Form::hidden('show_in_stock', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('show_in_stock', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('show_in_stock', $word['title_show_in_stock'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Show Count Viewers Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    <div class="form-check">
        {!! Form::hidden('show_count_viewers', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('show_count_viewers', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('show_count_viewers', $word['title_show_count_viewers'], ['class' => 'form-check-label']) !!}
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
