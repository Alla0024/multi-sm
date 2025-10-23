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
@include('components.inputs.multi_select', ['name' => 'filters', 'name_input' => 'filter[]', 'value' => $product ?? [], 'url' => 'getFilters', 'tab' => 'connections', 'second_id' => 'filter_group_id'])

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
