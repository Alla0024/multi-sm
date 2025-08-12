<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['name']['inTab'] !!}">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][name]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Comment Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['comment']['inTab'] !!}">
    {!! Form::label('descriptions_comment', $word['title_descriptions_comment']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][comment]", null, ['class' => '', 'rows' => 2]) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['type']['inTab'] !!}">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['path']['inTab'] !!}">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Option Value Groups Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['option_value_groups']['inTab'] !!}">
    {!! Form::label('option_value_groups', $word['title_option_value_groups']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('option_value_groups', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
