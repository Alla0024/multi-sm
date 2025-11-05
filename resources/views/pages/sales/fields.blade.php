@dump($sale)
{{--@dump($sale['segments'][0])--}}
@dump($sale['segments'][0]['products'])
{{--@dump($sale['segments'][0])--}}

<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', 'Назва') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description mini Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_mini_description', 'Міні опис акції') !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($sale))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_mini_description" placeholder="Username" name="descriptions[{{$language->id}}][mini_description]" aria-label="Username" aria-describedby="basic-addon1">{!! $sale['descriptions'][$language->id]['mini_description'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_mini_description" placeholder="Username" name="descriptions[{{$language->id}}][mini_description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Product Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_product_description', 'Опис акції в товарі') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][product_description]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_description', 'Опис') !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($sale))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_description" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1">{!! $sale['descriptions'][$language->id]['description'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_description" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Icon Field -->
<div class="form-group col-sm-6 tab-pane image-block" data-for-tab="main" x-data="{open_butt: false}">
    {!! Form::label('icon', 'Іконка') !!}
    <div class="input-group">
        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="thumbnail" type="hidden" name="avatar" value="{{$sale['icon'] ?? ''}}">
            <img class="" src="{{isset($sale['icon']) && $sale['icon'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$sale['icon'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path="/blog/Author"><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Thumbnail Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_thumbnail', 'Маленьке зображення (700x569 пікселів)') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group image-block mt-3" x-data="{open_butt: false}">
                <span class="input-group-text"  id="basic-addon1">{!! $word[$language->id] !!}</span>
                <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                    <input id="thumbnail_thumbnail_{{$language->id}}" type="hidden" name="descriptions[{{$language->id}}][thumbnail]" value="{{$sale['descriptions'][$language->id]['thumbnail'] ?? ''}}">
                    <img class="" src="{{isset($sale['descriptions'][$language->id]['thumbnail']) && $sale['descriptions'][$language->id]['thumbnail'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$sale['descriptions'][$language->id]['thumbnail'] : '/images/common/no_images.png'}}" id="holder_thumbnail_{{$language->id}}" alt="Прев’ю" style="max-width: 200px;">
                    <div class="butt hide" :class="{'show': open_butt}">
                        <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail_thumbnail_{{$language->id}}" data-preview="holder_thumbnail_{{$language->id}}" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                        <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Image Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_image', 'Велике зображення (800x531(1000x664) пікселів)') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group image-block mt-3" x-data="{open_butt: false}">
                <span class="input-group-text"  id="basic-addon1">{!! $word[$language->id] !!}</span>
                <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                    <input id="thumbnail_image_{{$language->id}}" type="hidden" name="descriptions[{{$language->id}}][image]" value="{{$sale['descriptions'][$language->id]['image'] ?? ''}}">
                    <img class="" src="{{isset($sale['descriptions'][$language->id]['image']) && $sale['descriptions'][$language->id]['image'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$sale['descriptions'][$language->id]['image'] : '/images/common/no_images.png'}}" id="holder_image_{{$language->id}}" alt="Прев’ю" style="max-width: 200px;">
                    <div class="butt hide" :class="{'show': open_butt}">
                        <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail_image_{{$language->id}}" data-preview="holder_image_{{$language->id}}" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                        <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Big banner Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_big_banner', 'Банер (1280x280 пікселів)') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group image-block mt-3" x-data="{open_butt: false}">
                <span class="input-group-text"  id="basic-addon1">{!! $word[$language->id] !!}</span>
                <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                    <input id="thumbnail_big_banner_{{$language->id}}" type="hidden" name="descriptions[{{$language->id}}][big_banner]" value="{{$sale['descriptions'][$language->id]['big_banner'] ?? ''}}">
                    <img class="" src="{{isset($sale['descriptions'][$language->id]['big_banner']) && $sale['descriptions'][$language->id]['big_banner'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$sale['descriptions'][$language->id]['big_banner'] : '/images/common/no_images.png'}}" id="holder_big_banner_{{$language->id}}" alt="Прев’ю" style="max-width: 450px;">
                    <div class="butt hide" :class="{'show': open_butt}">
                        <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail_big_banner_{{$language->id}}" data-preview="holder_big_banner_{{$language->id}}" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                        <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Small banner Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_small_banner', 'Міні банер (590x58 пікселів)') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group image-block mt-3" x-data="{open_butt: false}">
                <span class="input-group-text"  id="basic-addon1">{!! $word[$language->id] !!}</span>
                <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
                    <input id="thumbnail_small_banner_{{$language->id}}" type="hidden" name="descriptions[{{$language->id}}][small_banner]" value="{{$sale['descriptions'][$language->id]['small_banner'] ?? ''}}">
                    <img class="" src="{{isset($sale['descriptions'][$language->id]['small_banner']) && $sale['descriptions'][$language->id]['small_banner'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$sale['descriptions'][$language->id]['small_banner'] : '/images/common/no_images.png'}}" id="holder_small_banner_{{$language->id}}" alt="Прев’ю" style="max-width: 450px;">
                    <div class="butt hide" :class="{'show': open_butt}">
                        <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail_small_banner_{{$language->id}}" data-preview="holder_small_banner_{{$language->id}}" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                        <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Important info Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_important_info', 'Важлива інформація') !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($sale))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_important_info" placeholder="Username" name="descriptions[{{$language->id}}][important_info]" aria-label="Username" aria-describedby="basic-addon1">{!! $sale['descriptions'][$language->id]['important_info'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_important_info" placeholder="Username" name="descriptions[{{$language->id}}][important_info]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Date Start Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
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
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
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

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Show In Product Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('show_in_product', $word['title_show_in_product']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('show_in_product', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Show In Sale Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', 'Показувати в акціях') !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('show_in_sale', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Default Sale Shop Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', 'Акція за замовчуванням в магазинах') !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('default_sale_shop', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Accrue Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', 'Нарахування') !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('accrue', ['1' => 'так' , '0' => 'ні'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Compare Options Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', 'Порівняти опції товарів при обчисленні') !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('compare_options', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Has One Activator Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('has_one_activator', $word['title_has_one_activator']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('has_one_activator', ['1' => 'так' , '0' => 'ні'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Show More Sale Url Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('show_more_sale_url', $word['title_show_more_sale_url']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('show_more_sale_url', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
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

<!-- Loop Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main" style="background: #d3eef6; padding: 10px; margin-left: -10px">
    {!! Form::label('loop', 'Статус циклу') !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('loop', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Seo path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('seo_path', 'Seo-url') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            <input type="text" name="seo_url[path]" required value="{{$sale['seoPath']['path'] ?? ''}}">
        </div>
    </div>
</div>

<!-- Segment items Field -->
@include('pages.sales.segments')

<!-- Segments Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="segment">
    {!! Form::label('segments', 'Сегменти') !!}
    <div class="flex-row input">
        <div class="input-group input-tags">
            <select class="tag-select" name="sale_to_segment[]" data-no-search="true" multiple>
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
            <select class="tag-select" name="sale_to_payment[]" data-no-search="true" multiple>
                @foreach($paymentMethods as $item)
                    <option value="{{$item['id']}}" @if(isset($selectedPaymentsIds) && in_array((int)$item['id'], $selectedPaymentsIds)) selected @endif >{{$item['id']}} - {{$item['description']['title']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>



