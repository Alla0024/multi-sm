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
