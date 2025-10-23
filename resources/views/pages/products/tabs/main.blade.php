<!-- Article Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('article', "Модель") !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('article', null, ['class' => 'form-control', 'required', 'maxlength' => 50, 'maxlength' => 50]) !!}
        </div>
    </div>
</div>

<!-- Hash Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_hash']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('hash', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['0' => $word['status_inactive'], '1' => $word['status_active']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Mark Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('mark', 'Плашка') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            <select name="mark" class="form-control">
                <option @if(isset($product->mark) && $product->mark == null) selected @endif value="0">Вимкнено</option>
                <option @if(isset($product->mark) && $product->mark == '1') selected @endif value="1">Топ продаж</option>
                <option @if(isset($product->mark) && $product->mark == '2')  selected @endif value="2">Супер ціна</option>
                <option @if(isset($product->mark) && $product->mark == '3')  selected @endif value="3">Ексклюзив</option>
                <option @if(isset($product->mark) && $product->mark == '4')  selected @endif value="4">Чорна п'ятниця</option>
                <option @if(isset($product->mark) && $product->mark == '5')  selected @endif value="5">Предзамовлення</option>
                <option @if(isset($product->mark) && $product->mark == '6')  selected @endif value="6">Новинка</option>
                <option @if(isset($product->mark) && $product->mark == '7')  selected @endif value="7">Пара</option>
                <option @if(isset($product->mark) && $product->mark == '8')  selected @endif value="8">Подарунок</option>
                <option @if(isset($product->mark) && $product->mark == '9')  selected @endif value="9">Доставка</option>
            </select>
        </div>
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Path Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_path']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Kit Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('kit', $word['title_kit']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('kit', ['0' => $word['status_inactive'], '1' => $word['status_active']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
