@dump($product)
<!-- Article Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('article', $word['title_article']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('article', null, ['class' => 'form-control', 'required', 'maxlength' => 50, 'maxlength' => 50]) !!}
        </div>
    </div>
</div>

<!-- Hash Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_hash']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('hash', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['0' => $word['status_inactive'], '1' => $word['status_active']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Mark Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('mark', $word['title_mark']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            <select name="mark" class="form-control">
                <option @if(isset($product->mark) && $product->mark == null) selected @endif value="0">Вимкнено</option>
                <option @if(isset($product->mark) && $product->mark == '1') selected @endif value="1">Топ продаж</option>
                <option @if(isset($product->mark) && $product->mark == '2')  selected @endif value="2">Супер ціна</option>
                <option @if(isset($product->mark) && $product->mark == '3')  selected @endif value="3">Ексклюзив</option>
                <option @if(isset($product->mark) && $product->mark == '4')  selected @endif value="4">Чорна п'ятниця</option>
                <option @if(isset($product->mark) && $product->mark == '5')  selected @endif value="5">Предзамовлення</option>
                <option @if(isset($product->mark) && $product->mark == '6')  selected @endif value="6">Новинка</option>
                <option @if(isset($product->mark) && $product->mark == '7')  selected @endif value="7">Пара</option>
                <option @if(isset($product->mark) && $product->mark == '8')  selected @endif value="8">Подарунок</option>
                <option @if(isset($product->mark) && $product->mark == '9')  selected @endif value="9">Доставка</option>
            </select>
        </div>
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_path']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Kit Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('kit', $word['title_kit']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('kit', ['0' => $word['status_inactive'], '1' => $word['status_active']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="data">
    {!! Form::label('name', 'Назва') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => 'form-control']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Name In 1C Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="data">
    {!! Form::label('name_in_1c', $word['title_name_in_1c']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('name_in_1c', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Damage Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="data">
    {!! Form::label('damage', 'Опис пошкоджень товару') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][damage_comment]", null, ['class' => 'form-control']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Damage Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="data">
    Тут має бути Розташування з містами які я не зробив
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="data">
    {!! Form::label('descriptions_description', 'Опис') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($product))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="description[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1">{!! $product['descriptions'][$language->id]['description'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="description[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="data">
    {!! Form::label('type', 'Тип') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][type]", null, ['class' => 'form-control']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Tag Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="data">
    {!! Form::label('tag', 'Теги') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][tag]", null, ['class' => 'form-control']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Meta-title Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="data">
    {!! Form::label('meta', 'META Title') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][meta_title]", null, ['class' => 'form-control']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Meta-Description Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="data">
    {!! Form::label('meta-desc', 'META Description') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][meta_description]", null, ['class' => 'form-control']) !!}
            </div>
        @endforeach
    </div>
</div>





<!-- Sku Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('sku', $word['title_sku']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('sku', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Currency Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('currency_id', $word['title_currency_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('currency_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


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


<!-- Stock Status Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('stock_status_id', $word['title_stock_status_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('stock_status_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Rozetka Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('rozetka_status', $word['title_rozetka_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('rozetka_status', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Google Remarketing Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('google_remarketing_status', $word['title_google_remarketing_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('google_remarketing_status', null, ['class' => 'form-control', 'required']) !!}
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


<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('image', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Image Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="">
    {!! Form::label('image_path', $word['title_image_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('image_path', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
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
