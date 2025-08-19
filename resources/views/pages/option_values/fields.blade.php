<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['name']['inTab'] !!}">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Type Material Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['type_material']['inTab'] !!}">
    {!! Form::label('descriptions_type_material', $word['title_descriptions_type_material']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][type_material]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Parent Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['parent_id']['inTab'] !!}">
    {!! Form::label('parent_id', $word['title_parent_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('parent_id', old('parent_id', $parentId ?? null), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['image']['inTab'] !!}">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('image', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['type']['inTab'] !!}">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('type', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
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

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['status']['inTab'] !!}">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('status', ['1' => $word['status_active'] , '0' => $word['status_inactive']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Default Field -->

<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['default']['inTab'] !!}">
    {!! Form::label('default', $word['title_default']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::select('default', ['1' => $word['status_active'] , '0' => $word['status_inactive']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

@if(str_contains(request()->path(), 'edit'))
    <!-- Toggle Children Status Field -->
    <div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['children_status']['inTab'] !!}">
        {!! Form::label('children_status', $word['title_children_status']) !!}
        <div class="flex-row input">
            <div class="input-group">
                {!! Form::select('children_status', [null => 'Змінити статус дочірніх елементів', true => 'Активний', false => 'Неактивний'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <!-- Level Field -->
    <div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['level']['inTab'] !!}">
        {!! Form::label('level', $word['title_level']) !!}
        <div class="flex-row input">
            <div class="input-group">
                {!! Form::number('level', null, ['class' => 'form-control', 'required', 'disabled']) !!}
            </div>
        </div>
    </div>

@endif
