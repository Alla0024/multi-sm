
<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'rows' => 2, 'required' ]) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_comment', $word['title_descriptions_description']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::textarea("descriptions[$language->id][description]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Tag Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_comment', $word['title_descriptions_tag']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][tag]", null, ['class' => '', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="main" x-data="manufacture">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="input-group">
        <div class="custom-file image-upload">
            <label for="image" class="custom-file-label lfm" data-input="thumbnail" data-preview="holder" data-path=""><i class="bi bi-arrow-up-square"></i></label>
            <input id="thumbnail" type="hidden" name="image" value="{{$manufacturer['image'] ?? ''}}">
            <img class="hide @if(isset($manufacturer['image'])) show @endif " src="{{$manufacturer['image'] ?? ''}}" id="holder" alt="Прев’ю" style="max-width: 200px;">

        </div>
    </div>
{{--    <div class="" >Обрати</div>--}}

{{--    <img  alt="" style="max-width:200px;">--}}
</div>
<div class="clearfix"></div>

<!-- Seo Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', ()=>{
        Alpine.data('manufacture', () => ({

        }))
    })
</script>
