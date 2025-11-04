@dump($sale)

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





































<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('status', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('status', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('status', $word['title_status'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Hidden Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hidden', $word['title_hidden']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('hidden', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Date Start Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('date_start', $word['title_date_start']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('date_start', null, ['class' => 'form-control','id'=>'date_start']) !!}
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
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::date('date_end', null, ['class' => 'form-control','id'=>'date_end']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_end').datepicker()
    </script>
@endpush


<!-- Time Start Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('time_start', $word['title_time_start']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('time_start', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Time End Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('time_end', $word['title_time_end']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('time_end', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Loop Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('loop', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('loop', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('loop', $word['title_loop'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Show In Product Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('show_in_product', $word['title_show_in_product']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('show_in_product', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Show In Sale Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('show_in_sale', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('show_in_sale', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('show_in_sale', $word['title_show_in_sale'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Show More Sale Url Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('show_more_sale_url', $word['title_show_more_sale_url']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('show_more_sale_url', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Default Sale Shop Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('default_sale_shop', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('default_sale_shop', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('default_sale_shop', $word['title_default_sale_shop'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Compare Options Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('compare_options', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('compare_options', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('compare_options', $word['title_compare_options'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Has One Activator Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('has_one_activator', $word['title_has_one_activator']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('has_one_activator', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Accrue Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    <div class="form-check">
        {!! Form::hidden('accrue', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('accrue', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('accrue', $word['title_accrue'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Icon Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('icon', $word['title_icon']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('icon', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>
