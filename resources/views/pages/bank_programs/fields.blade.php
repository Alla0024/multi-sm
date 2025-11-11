{{--@dump($bankProgram)--}}

<!-- Mark Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('mark', $word['title_mark']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::text('mark', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Bank Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_bank_id']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            <select class="" name="bank_id"  aria-describedby="select-addon">
                @foreach($bank as $item)
                    <option value="{{$item['id']}}" @if(isset($bankProgram) && $bankProgram['bank_id'] == $item['id']) selected @endif>{{$item['descriptions'][1]['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- Logo Field -->
<div class="form-group col-sm-6 tab-pane image-block" data-for-tab="main" x-data="{open_butt: false}">
    {!! Form::label('logo', 'Лого') !!}
    <div class="input-group">
        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="thumbnail" type="hidden" name="logo" value="{{$bankProgram['logo'] ?? ''}}">
            <img class="" src="{{isset($bankProgram['logo']) && $bankProgram['logo'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$bankProgram['logo'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path=""><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
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


<!-- Min Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('min', $word['title_min']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('min', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Max Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('max', $word['title_max']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('max', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Step Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('step', $word['title_step']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('step', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Value Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('value', $word['title_value']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('value', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Month Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('month', $word['title_month']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('month', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['1' => $word['status_1'] , '0' => $word['status_0']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
