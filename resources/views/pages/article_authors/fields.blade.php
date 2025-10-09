<!-- Avatar Field -->
<div class="form-group col-sm-6 tab-pane image-block" data-for-tab="main" x-data="{open_butt: false}">
    {!! Form::label('image', $word['title_avatar']) !!}
    <div class="input-group">
        <div class="custom-file image-upload" @click="open_butt = !open_butt" @keydown.escape.window="open_butt=false" @click.outside="open_butt=false">
            <input id="thumbnail" type="hidden" name="avatar" value="{{$articleAuthor['avatar'] ?? ''}}">
            <img class="" src="{{isset($articleAuthor['avatar']) && $articleAuthor['avatar'] != '' ? "https://i.svit-matrasiv.com.ua/storage/images/".$articleAuthor['avatar'] : '/images/common/no_images.png'}}" id="holder" alt="Прев’ю" style="max-width: 200px;">
            <div class="butt hide" :class="{'show': open_butt}">
                <div class="custom-file-label lfm" @click="$store.page.bindFileManager($event.target)" data-input="thumbnail" data-preview="holder" data-path="/blog/Author"><i class="bi bi-arrow-up-square"></i></div>
                <div class="clear-img" @click="console.log($event.target)"><i class="bi bi-trash-fill"></i></div>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_of_birth').datepicker()
    </script>
@endpush

<!-- SEO url -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::text('path', null, ['class' => 'form-control input-min', 'required']) !!}
        </div>
    </div>
</div>

<!-- Facebook Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('facebook', $word['title_facebook']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::text('facebook', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Instagram Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
    {!! Form::label('instagram', $word['title_instagram']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::text('instagram', null, ['class' => 'form-control ', 'required']) !!}
        </div>
    </div>
</div>

<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3  input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => 'form-control', 'required' ]) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_description', $word['title_descriptions_description']) !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($articleAuthor))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1">{!! $articleAuthor['descriptions'][$language->id]['description'] ?? '' !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>
