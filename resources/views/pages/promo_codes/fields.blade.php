{{--@dump($promoCode)--}}
{{--@dump($promoCodeGroups[0])--}}

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
                @if(isset($promoCode))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_description" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1">{!! $promoCode['descriptions'][$language->id]['description'] ?? '' !!}</textarea>
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
                    <input id="thumbnail_image_{{$language->id}}" type="hidden" name="descriptions[{{$language->id}}][image]" value="{{$promoCode['descriptions'][$language->id]['image'] ?? ''}}">
                    <img class="" src="{{isset($promoCode['descriptions'][$language->id]['image']) && $promoCode['descriptions'][$language->id]['image'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$promoCode['descriptions'][$language->id]['image'] : '/images/common/no_images.png'}}" id="holder_image_{{$language->id}}" alt="Прев’ю" style="max-width: 200px;">
                    <div class="butt hide" :class="{'show': open_butt}">
                        <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail_image_{{$language->id}}" data-preview="holder_image_{{$language->id}}" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                        <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Value Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('value', 'Значення') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('value', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Type Number Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type_number', $word['title_type_number']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('type_number', ['percent' => 'Процент %' , 'fixed_number' => 'Фіксоване число'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Change Number Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('change_number', 'Змінити ціну') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('change_number', ['0' => 'Ні' , '1' => 'Так'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('code', $word['title_code']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('code', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Promo code group Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('promo_code_group', 'Група промокодів') !!}
    <div class="flex-row input input-min">
        <div class="input-group input-list-search" style="position: relative;">
            @isset($promoCode['promo_code_group_id'])
                <input type="hidden" name="promo_code_group_id" value="{{$promoCode['promo_code_group_id']}}">
            @else
                <input type="hidden" name="promo_code_group_id" value="">
            @endisset
            <input
                    class="ignore_form"
                    name="promo_code_group_id"
                    placeholder="Пошук..."
                    autocomplete="off"
                    value="@if(isset($promoCodeGroups)) {{ $promoCodeGroups->firstWhere('description.promo_code_group_id', $promoCode['promo_code_group_id'])['description']['name'] ?? ''}} @endif"
                    data-url=""
                    @input="$store.page.searchSelect($event.target)"
                    @focus="$store.page.searchSelect($event.target)"
                    custom="true"
            >
            <ul class="custom-list hide">
                @if(isset($promoCodeGroups))
                    @foreach($promoCodeGroups as $item)
                        <li id="{{$item['description']['promo_code_group_id']}}">{{$item['description']['name']}}</li>
                    @endforeach
                @endif
            </ul>
            <div class="svg">
                <img src="/images/common/arrow_select.png" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Number Of Uses Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('number_of_uses', $word['title_number_of_uses']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('number_of_uses', null, ['class' => 'form-control', 'required']) !!}
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



