<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane image-block" data-for-tab="main" x-data="{open_butt: false}">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="input-group">
        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="thumbnail" type="hidden" name="image" value="{{$attributeIcon['image'] ?? ''}}">
            <img class="" src="{{isset($attributeIcon['image']) && $attributeIcon['image'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$attributeIcon['image'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path="attributeicons/2021_matrasy"><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
        </div>
    </div>
</div>


<!-- Pattern Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('pattern', $word['title_pattern']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::textarea('pattern', '', ['class' => '', 'required']) !!}
        </div>
    </div>
</div>


<!-- Value Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('value', $word['title_value']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('value', '', ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
