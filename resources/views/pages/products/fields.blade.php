{{--@dump($product)--}}
<!-- Article Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('article', "Модель") !!}
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
    {!! Form::label('mark', 'Плашка') !!}
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

<!-- Location Damage Field -->
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

<!-- Category Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="connections">
    {!! Form::label('category_id', 'Головна категорія') !!}
    <div class="flex-row input input-min">
        <div class="input-group input-list-search" style="position: relative;">
            @isset($product['category_id'])
                <input type="hidden" name="category_id" value="{{$product['category_id']}}">
            @else
                <input type="hidden" name="category_id" value="">
            @endisset
            <input
                class="ignore_form"
                name="category_id"
                placeholder="Пошук..."
                autocomplete="off"
                value="{{$product['category']['description']['name'] ?? ''}}"
                data-url="{{route('getCategories')}}"
                @input="$store.page.searchSelect($event.target)"
                @focus="$store.page.searchSelect($event.target)"
                custom="true"
            >
            <ul class="custom-list hide">

            </ul>
            <div class="svg">
                <img src="/images/common/arrow_select.png" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Sku Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="connections">
    {!! Form::label('sku', 'СКУ') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('sku', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Manufacture Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="connections">
    {!! Form::label('manufacturer_id', 'Виробник') !!}
    <div class="flex-row input input-min">
        <div class="input-group input-list-search" style="position: relative;">
            @isset($product['manufacturer_id'])
                <input type="hidden" name="manufacturer_id" value="{{$product['manufacturer_id']}}">
            @else
                <input type="hidden" name="manufacturer_id" value="">
            @endisset
            <input
                class="ignore_form"
                name="manufacturer_id"
                placeholder="Пошук..."
                autocomplete="off"
                value="{{$product['manufacturer']['description']['name'] ?? ''}}"
                data-url="{{route('getManufacturers')}}"
                @input="$store.page.searchSelect($event.target)"
                @focus="$store.page.searchSelect($event.target)"
                custom="true"
            >
            <ul class="custom-list hide">

            </ul>
            <div class="svg">
                <img src="/images/common/arrow_select.png" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Kit Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="connections">
    {!! Form::label('manufacturer_id', 'Комплект') !!}
    <div class="flex-row input input-min">
        <div class="input-group input-list-search" style="position: relative;">
            @isset($product['kit'])
                <input type="hidden" name="manufacturer_id" value="{{$product['kit']}}">
            @else
                <input type="hidden" name="manufacturer_id" value="">
            @endisset
            <input
                class="ignore_form"
                name="manufacturer_id"
                placeholder="Пошук..."
                autocomplete="off"
                value="{{$product['kitProducts']['description']['name'] ?? ''}}"
                data-url="{{route('getKits')}}"
                @input="$store.page.searchSelect($event.target)"
                @focus="$store.page.searchSelect($event.target)"
                custom="true"
            >
            <ul class="custom-list hide">

            </ul>
            <div class="svg">
                <img src="/images/common/arrow_select.png" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Currency Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="connections">
    {!! Form::label('currency_id', $word['title_currency_id']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            <select  name="currency_id"  >
                <option value=""  selected >Усе</option>
                <option value="3" @if(isset($product['currency_id']) && $product['currency_id'] == 3) selected @endif>
                    EUR
                </option>
                <option value="4" @if(isset($product['currency_id']) && $product['currency_id'] == 4) selected @endif>
                    UAH
                </option>
                <option value="5" @if(isset($product['currency_id']) && $product['currency_id'] == 5) selected @endif>
                    USD
                </option>
{{--                @foreach($currencies as $item)--}}
{{--                    <option value="{{$item['id']}}" @if(isset($product['currency_id']) && $product['currency_id'] == $item['id']) selected @endif>--}}
{{--                        {{$item['code']}}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
            </select>
        </div>
    </div>
</div>

<!-- Stock Status Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="connections">
    {!! Form::label('stock_status_id', $word['title_stock_status_id']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            <select  name="stock_status_id"  >
                @if(!isset($product['stock_status_id']))
                    <option selected disabled value="">Виберіть статус</option>
                @endif
                <option value="4" @if(isset($product['stock_status_id']) && $product['stock_status_id'] == 4) selected @endif>
                    Продано
                </option>
                <option value="5" @if(isset($product['stock_status_id']) && $product['stock_status_id'] == 5) selected @endif>
                    Немає в наявності
                </option>
                <option value="6" @if(isset($product['stock_status_id']) && $product['stock_status_id'] == 6) selected @endif>
                    Очікування
                </option>
                <option value="7" @if(isset($product['stock_status_id']) && $product['stock_status_id'] == 7) selected @endif>
                    В наявності
                </option>
                <option value="8" @if(isset($product['stock_status_id']) && $product['stock_status_id'] == 8) selected @endif>
                    Під замовлення
                </option>
                <option value="9" @if(isset($product['stock_status_id']) && $product['stock_status_id'] == 9) selected @endif>
                    Знятий з виробництва
                </option>
                {{--                @foreach($stock_statuses as $item)--}}
                {{--                    <option value="{{$item['id']}}" @if(isset($product['stock_status_id']) && $product['stock_status_id'] == $item['id']) selected @endif>--}}
                {{--                        {{$item['description']['name'}}--}}
                {{--                    </option>--}}
                {{--                @endforeach--}}
            </select>
        </div>
    </div>
</div>

<!-- Filters Field -->
@include('components.inputs.multi_select', ['name' => 'filters', 'name_input' => 'filter[]', 'value' => $product ?? [], 'url' => 'getFilters', 'tab' => 'connections'])

<!-- Companion Field -->
@include('components.inputs.multi_select', ['name' => 'companions', 'name_input' => 'companions[]', 'value' => $product ?? [], 'url' => 'getFilters', 'tab' => 'connections', 'id_name' => 'companion_id'])

<!-- Rozetka Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="connections">
    {!! Form::label('rozetka_status', $word['title_rozetka_status']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('rozetka_status', ['1' => $word['status_active'] , '0' => $word['status_inactive']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Google Remarketing Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="connections">
    {!! Form::label('google_remarketing_status', $word['title_google_remarketing_status']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('google_remarketing_status', ['1' => $word['status_active'] , '0' => $word['status_inactive']], null, ['class' => 'form-control', 'required']) !!}
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
