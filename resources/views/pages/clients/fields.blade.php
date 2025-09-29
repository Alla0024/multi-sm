
<!-- Photo Field -->
<div class="form-group col-sm-6 tab-pane image-block" data-for-tab="main" x-data="{open_butt: false}">
    {!! Form::label('photo', $word['title_photo']) !!}
    <div class="input-group">
        <div class="custom-file image-upload" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="thumbnail" type="hidden" name="photo" value="{{$client['image'] ?? ''}}">
            <img class="" src="{{isset($client['photo']) && $client['photo'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$client['photo'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path="/catalog/category/logo_wtm"><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
        </div>
    </div>
</div>


<!-- Surname Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('surname', $word['title_surname']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('surname', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('name', $word['title_name']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Birthday Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('birthday', $word['title_birthday']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::datetimelocal('birthday', null, ['class' => 'form-control','id'=>'birthday', 'disabled']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#birthday').datepicker()
    </script>
@endpush


<!-- Email Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('email', $word['title_email']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::email('email', '', ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>


<!-- Phone Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('phone', $word['title_phone']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'disabled']) !!}
        </div>
    </div>
</div>

<!-- Hash Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('hash', $word['title_hash']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('hash', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
    </div>
</div>



@push('page_scripts')
    <script type="text/javascript">
        $('#updated_at_1c').datepicker()
    </script>
@endpush
