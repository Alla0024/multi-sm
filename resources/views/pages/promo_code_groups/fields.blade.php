@dump($promoCodeGroup)
<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', 'Назва промокоду') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Title Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_title', 'Заголовок промокоду') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][title]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_description', 'Опис бонусної програми') !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($promoCodeGroup))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_description" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1">{!! $promoCodeGroup['descriptions'][$language->id]['description'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_description" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Images Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_image', 'Зображення') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group image-block mt-3" x-data="{open_butt: false}">
                <span class="input-group-text"  id="basic-addon1">{!! $word[$language->id] !!}</span>
                <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                    <input id="thumbnail_image_{{$language->id}}" type="hidden" name="descriptions[{{$language->id}}][image]" value="{{$promoCodeGroup['descriptions'][$language->id]['image'] ?? ''}}">
                    <img class="" src="{{isset($promoCodeGroup['descriptions'][$language->id]['image']) && $promoCodeGroup['descriptions'][$language->id]['image'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$promoCodeGroup['descriptions'][$language->id]['image'] : '/images/common/no_images.png'}}" id="holder_image_{{$language->id}}" alt="Прев’ю" style="max-width: 200px;">
                    <div class="butt hide" :class="{'show': open_butt}">
                        <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail_image_{{$language->id}}" data-preview="holder_image_{{$language->id}}" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                        <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Apply Immediately Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('apply_immediately', 'Застосувати одразу') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('apply_immediately', ['0' => 'Ні' , '1' => 'Так'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Must Be All Products Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('must_be_all_products', 'Мають бути всі товари із списку') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('must_be_all_products', ['0' => 'Ні' , '1' => 'Так'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Apply For Products Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('apply_for_products', 'Застосування знижки до') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('apply_for_products', ['0' => 'Усі товари в кошику' , '1' => 'Товари-активатори'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Min Total Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('min_total_price', 'Загальне мінімальне значення кошика') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('min_total_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Max Total Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('max_total_price', 'Загальне максимальне значення кошика') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('max_total_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Min Total Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('min_product_price', 'Мінімальне значення продукту') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('min_product_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Max Total Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('max_product_price', 'Максимальне значення продукту') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('max_product_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Date Start Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_start', 'Початок дії') !!}
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
    {!! Form::label('date_end', 'Кінець дії') !!}
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

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>











