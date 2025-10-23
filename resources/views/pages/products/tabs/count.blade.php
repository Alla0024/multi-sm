<!-- Show In Stock Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="count">
    {!! Form::label('show_in_stock', $word['title_show_in_stock'], ['class' => 'form-check-label']) !!}
    <div class="input-block input-toggle flex">
        <div class="form-check form-switch" style="margin: 0">
            <input class="form-check-input checkbox-child" data-content="as" name="show_in_stock" type="checkbox" role="switch" id="switchCheckChecked_show_in_stock">
        </div>
    </div>
</div>

<!-- Show Count Viewers Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="count">
    <div class="form-check">
        {!! Form::hidden('show_count_viewers', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('show_count_viewers', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('show_count_viewers', $word['title_show_count_viewers'], ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Viewers Number From Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="count">
    {!! Form::label('viewers_number_from', $word['title_viewers_number_from']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('viewers_number_from', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Viewers Number To Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="count">
    {!! Form::label('viewers_number_to', $word['title_viewers_number_to']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('viewers_number_to', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

