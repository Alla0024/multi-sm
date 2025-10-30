{{--@dump($bonusProgram)--}}

<!-- Stores Field -->
@include('components.inputs.stores_multi_select', ['name' => 'stores', 'value' => $bonusProgram ?? []])

<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', 'Назва 1C') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_description', 'Опис із 1C') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][description]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Header Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_header', 'Заголовок') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][header]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Text Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_text', 'Опис бонусної програми') !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($bonusProgram))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_text" placeholder="Username" name="descriptions[{{$language->id}}][text]" aria-label="Username" aria-describedby="basic-addon1">{!! $bonusProgram['descriptions'][$language->id]['text'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_text" placeholder="Username" name="descriptions[{{$language->id}}][text]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Mini description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_mini_description', 'Опис на банері') !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($bonusProgram))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_mini" placeholder="Username" name="descriptions[{{$language->id}}][mini_description]" aria-label="Username" aria-describedby="basic-addon1">{!! $bonusProgram['descriptions'][$language->id]['mini_description'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}_mini" placeholder="Username" name="descriptions[{{$language->id}}][mini_description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Hash Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_hash']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('hash', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input input-min">
        <div class="input-group input-min">
            {!! Form::select('type', ['special' => 'Спеціальний' , 'base' => 'Базовий'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Color Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('color', $word['title_color']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('color', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Started At Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('started_at', 'Початок') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::datetimelocal('started_at', null, ['class' => 'form-control','id'=>'started_at']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#started_at').datepicker()
    </script>
@endpush

<!-- Finished At Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('finished_at', 'Закінчення') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::datetimelocal('finished_at', null, ['class' => 'form-control','id'=>'finished_at']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#finished_at').datepicker()
    </script>
@endpush

<!-- Usage Percentage Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('usage_percentage', 'Відсоток використання') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('usage_percentage', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Min Total Price Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('min_total_price', 'Мінімальна загальна ціна') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('min_total_price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Priority Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('priority', $word['title_priority']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('priority', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Seo url Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('seo', 'Seo-url') !!}
    <div class="flex-row input input-min">
        <div class="input-group" style="flex-direction: column">
            @if(isset($bonusProgram['seoPath']))
                <input type="hidden" required name="seo_url[id]" value="{{$bonusProgram['seoPath']['type_id']}}">
                <a style="color: #81a4ff; margin-bottom: 6px" target="_blank" href="{{config('app.client_url')}}{{$bonusProgram['seoPath']['path']}}.html">Seo-Url</a>
            @endif
            <input  data-name="seo_url[path]" id="input_seo_url" placeholder="Seo-Url" type="text" class="form-control seo-url-input" minlength="3" required name="{{ !isset($product['seoPath']) ? "seo_url[path]" : '' }}" value="@if(isset($bonusProgram['seoPath']['path'])){{$bonusProgram['seoPath']['path']}}@endif">

        </div>
    </div>
</div>

<!-- Segments Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="segment">
    {!! Form::label('segments', 'Сегменти') !!}
    <div class="flex-row input">
        <div class="input-group input-tags">
            <select class="tag-select" name="bonus_program_to_segment[]" data-no-search="true" multiple>
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
            <select class="tag-select" name="bonus_program_to_payment[]" data-no-search="true" multiple>
                @foreach($paymentMethods as $item)
                    <option value="{{$item['id']}}" @if(isset($selectedPaymentsIds) && in_array((int)$item['id'], $selectedPaymentsIds)) selected @endif >{{$item['id']}} - {{$item['description']['title']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
