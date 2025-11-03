@dump($bannerGroup)
@dump($banners)

<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('name', $word['title_name']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('type', [
                'all' => 'Всі типи' ,
                'square' => 'банер как на розетке',
                'product' => 'продукт',
                'category' => 'категорія',
            ], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Layout Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('layout', 'Місце відображення') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('layout', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Width Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('width', $word['title_width']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('width', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Height Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('height', $word['title_height']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('height', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('status', ['0' => 'Ні' , '1' => 'Так'], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>



@include('components.table.table_items', ['inputType' => $arrData, 'data' => $filters ?? [], 'dataMultiSelect' => isset($options) ? $options->firstWhere('description.option_id', $filterGroup['option_id'])['optionValueGroups'] ?? '' : '', 'name' => 'filter', 'id_name' => 'filter_id', 'tab' => 'main'])

