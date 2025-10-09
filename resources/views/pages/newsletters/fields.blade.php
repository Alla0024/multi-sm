<!-- Title Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('title', $word['title_title']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', $word['title_type']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('type', $newsletter['types'] ?? '', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane image-block" data-for-tab="main" x-data="{open_butt: false}">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="input-group">
        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="thumbnail" type="hidden" name="image" value="{{$manufacturer['image'] ?? ''}}">
            <img class="" src="{{isset($newsletter['image']) && $newsletter['image'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$newsletter['image'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path="newsletters"><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Viber Message Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('viber_message', $word['title_viber_message']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::textarea('viber_message', null, ['class' => '']) !!}
        </div>
    </div>
</div>

<!-- Sms Message Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sms_message', $word['title_sms_message']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::textarea('sms_message', null, ['class' => '']) !!}
        </div>
    </div>
</div>


<!-- Button Text Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('button_text', $word['title_button_text']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::text('button_text', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Button Url Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('button_url', $word['title_button_url']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::text('button_url', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>


<!-- Phones Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('phones', $word['title_phones']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::textarea('phones', null, ['class' => '', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
        </div>
    </div>
</div>


<!-- Start In Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('start_in', $word['title_start_in']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::datetimelocal('start_in', null, ['class' => 'form-control','id'=>'start_in']) !!}
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#start_in').datepicker()
    </script>
@endpush


<!-- Author Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('author', $word['title_author']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('author', $newsletter['authors'] ?? [], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['1' => $word['status_active'] , '0' => $word['status_inactive']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
