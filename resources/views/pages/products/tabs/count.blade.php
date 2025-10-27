<!-- Show In Stock Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="count">
    {!! Form::label('show_in_stock', 'Кількість товарів в наявності', ['class' => 'form-check-label']) !!}
    <div class="input-block input-toggle flex">

        <div class="form-check form-switch content-switch" style="margin: 0" x-data="{check: @if(isset($product['show_in_stock']) && $product['show_in_stock'] == 1) true @else false @endif}">
            <input type="hidden" name="show_in_stock" :value="+check">
            <input class="form-check-input ignore_form checkbox-child" @change="check = !check" :checked="check" name="" type="checkbox" role="switch" id="switchCheckChecked_show_in_stock">
        </div>
    </div>
</div>

<!-- Show Count Viewers Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="count">
    {!! Form::label('show_count_viewers', 'Кількість глядачів', ['class' => 'form-check-label']) !!}
    <div class="form-check">
        <div class="input-block input-toggle flex">
            <div class="form-check form-switch content-switch" style="margin: 0" x-data="{check: @if(isset($product['show_count_viewers']) && $product['show_count_viewers'] == 1) true @else false @endif}">
                <input type="hidden" name="show_count_viewers" :value="+check">
                <input class="form-check-input ignore_form checkbox-child" @change="check = !check" :checked="check" name="" type="checkbox" role="switch" id="switchCheckChecked_show_count_viewers">
            </div>
        </div>
    </div>
</div>

<!-- Viewers Number From Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="count">
    {!! Form::label('viewers_number_from', $word['title_viewers_number_from']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('viewers_number_from', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<!-- Viewers Number To Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="count">
    {!! Form::label('viewers_number_to', $word['title_viewers_number_to']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('viewers_number_to', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

