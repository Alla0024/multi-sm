<!-- News Id Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['news_id']['inTab'] !!}">
    {!! Form::label('news_id', $word['title_news_id']) !!}
    {!! Form::number('news_id', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- News Category Id Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['news_category_id']['inTab'] !!}">
    {!! Form::label('news_category_id', $word['title_news_category_id']) !!}
    {!! Form::number('news_category_id', null, ['class' => 'form-control', 'required']) !!}
</div>
