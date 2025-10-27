<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane image-block" x-data="{open_butt: false}" data-for-tab="images">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="input-group">
        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="image" type="hidden" name="image" value="{{$product['image'] ?? ''}}">
            <img class="" src="{{isset($product['image']) && $product['image'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$product['image'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Image Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="images">
    {!! Form::label('image_path', $word['title_image_path']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('image_path', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Images table Field -->
@php
    $arrData = [
        'image' => ['type' => 'image', 'name' => 'Зображення', 'description' => false],
        'alt' => ['type' => 'string', 'name' => 'Alt', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
        'show_second' => ['type' => 'switch', 'name' => 'Показувати другою картинкою в категорії', 'description' => false],
    ];
@endphp

@include('components.table.table_items', ['inputType' => $arrData, 'data' => $product['images'] ?? [], 'search_select_type' => 'def', 'name' => 'images', 'id_name' => 'product_id', 'tab' => 'images', 'parse' => false])

<style>
    .table-data-items[data-for-tab='images']{
        .custom-type-switch{
            max-width: 200px !important;
        }
        .custom-type-number{
            max-width: 100% !important;
        }
    }

</style>
