<!-- News Category Id Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['news_category_id']['inTab'] !!}">
    {!! Form::label('news_category_id', $word['title_news_category_id']) !!}
    {!! Form::number('news_category_id', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Language Id Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['language_id']['inTab'] !!}">
    {!! Form::label('language_id', $word['title_language_id']) !!}
    {!! Form::number('language_id', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['name']['inTab'] !!}">
    {!! Form::label('name', $word['title_name']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>
