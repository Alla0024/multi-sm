<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['status']['inTab'] !!}">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('status', ['1' => $word['status_active'] , '0' => $word['status_inactive']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Title Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['title']['inTab'] !!}">
    {!! Form::label('descriptions_title', $word['title_descriptions_title']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][title]", null, ['class' => '', 'rows' => 2, 'required' ]) !!}
            </div>
        @endforeach
    </div>
</div>
{{--@dd($vacancy)--}}
<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['description']['inTab'] !!}">
    {!! Form::label('descriptions_description', $word['title_descriptions_description']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($vacancy))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1">{!! $vacancy['descriptions'][$language->id]['description'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Contact Person Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['name_contact_person']['inTab'] !!}">
    {!! Form::label('descriptions_name_contact_person', $word['title_descriptions_name_contact_person']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name_contact_person]", null, ['class' => '', 'rows' => 2, 'required' ]) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Payment Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['payment']['inTab'] !!}">
    {!! Form::label('payment', $word['title_payment']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('payment', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['phone']['inTab'] !!}">
    {!! Form::label('phone', $word['title_phone']) !!}
    <div class="flex-row input">
        <div class="input-group">
            <input type="text" value="{{$vacancy['phone'] ?? ''}}" required x-on:input="$store.page.mask($el)" x-on:paste="$nextTick(() => $store.page.mask($el))">
        </div>
    </div>
</div>

<!-- Location Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['location_id']['inTab'] !!}">
    {!! Form::label('location_id', $word['title_location_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('location_id', $locations ?? null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
