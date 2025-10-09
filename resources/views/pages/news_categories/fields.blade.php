<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Seo Url Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="main">
    {!! Form::label('seo_url', $word['title_seo_url']) !!}
    {!! Form::text('seo_url', null, ['class' => 'form-control input-min', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>


<!-- Color Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="main">
    {!! Form::label('color', $word['title_color']) !!}
    {!! Form::text('color', null, ['class' => 'form-control input-min', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>


<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control input-min', 'required']) !!}
</div>
