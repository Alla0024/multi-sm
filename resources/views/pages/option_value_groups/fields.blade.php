<!-- Option Id Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['option_id']['inTab'] !!}">
    {!! Form::label('option_id', $word['title_option_id']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('option_id', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Css Code Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['css_code']['inTab'] !!}">
    {!! Form::label('css_code', $word['title_css_code']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('css_code', null, ['class' => 'form-control', 'required', 'maxlength' => 55, 'maxlength' => 55]) !!}
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


<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['path']['inTab'] !!}">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
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
