<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['image']['inTab'] !!}">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('image', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Pattern Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="{!! $fields['pattern']['inTab'] !!}">
    {!! Form::label('pattern', $word['title_pattern']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('pattern', null, ['class' => '', 'required']) !!}
        </div>
    </div>
</div>


<!-- Value Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['value']['inTab'] !!}">
    {!! Form::label('value', $word['title_value']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('value', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
