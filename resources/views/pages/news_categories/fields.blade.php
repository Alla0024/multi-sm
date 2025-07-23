<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['status']['inTab'] !!}">
    <div class="form-check">
        {!! Form::hidden('status', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('status', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('status', $word['title_status'], ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Seo Url Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['seo_url']['inTab'] !!}">
    {!! Form::label('seo_url', $word['title_seo_url']) !!}
    {!! Form::text('seo_url', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>


<!-- Color Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['color']['inTab'] !!}">
    {!! Form::label('color', $word['title_color']) !!}
    {!! Form::text('color', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>


<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
</div>
