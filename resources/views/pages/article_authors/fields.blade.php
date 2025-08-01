<!-- Avatar Field -->

<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['avatar']['inTab'] !!}">
    {!! Form::label('avatar', $word['title_avatar']) !!}
    <div class="flex-row input">
        <div class="input-group">
            <div class="custom-file image-upload">
                {!! Form::file('avatar', ['class' => 'custom-file-input']) !!}
                @if(isset($articleAuthor))
                <img src="https://i.svit-matrasiv.com.ua/storage/images/{{$articleAuthor['avatar']}}" alt="Прев’ю" title="{{$articleAuthor['avatar']}}" style="max-width: 200px; margin-top: 10px; @if(isset($articleAuthor['avatar']) && $articleAuthor['avatar']) display: block; @else display: none; @endif">
                @else
                    <img src="" alt="Прев’ю" title="" style="max-width: 200px; margin-top: 10px;  display: none;">
                @endif
                <label for="avatar" class="custom-file-label"><i class="bi bi-arrow-up-square"></i></label>
            </div>
        </div>
    </div>
</div>

<!-- Date Of Birth Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['date_of_birth']['inTab'] !!}">
    {!! Form::label('date_of_birth', $word['title_date_of_birth']) !!}
    <div class="flex-row input">
        <div class="input-group">
            @if(isset($articleAuthor))
            <input
                type="date"
                name="date_of_birth"
                value="{{ substr($articleAuthor['date_of_birth'], 0, 10) }}"
                aria-label="Дата"
                aria-describedby="datetime-addon"
            >
            @else
                <input
                    type="date"
                    name="date_of_birth"
                    value="{{ date('Y-m-d') }}"
                    aria-label="Дата"
                    aria-describedby="datetime-addon"
                >
            @endif
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_of_birth').datepicker()
    </script>
@endpush

<!-- SEO url -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="{!! $fields['path']['inTab'] !!}">
    {!! Form::label('path', $word['title_path']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('path', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Facebook Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="{!! $fields['facebook']['inTab'] !!}">
    {!! Form::label('facebook', $word['title_facebook']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('facebook', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>


<!-- Instagram Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="{!! $fields['instagram']['inTab'] !!}">
    {!! Form::label('instagram', $word['title_instagram']) !!}
    <div class="flex-row input">
        <div class="input-group">
            {!! Form::text('instagram', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<!-- Title Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['title']['inTab'] !!}">
    {!! Form::label('descriptions_title', $word['title_descriptions_title']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][title]", null, ['class' => 'form-control', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['title']['inTab'] !!}">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => 'form-control', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="{!! $fields['title']['inTab'] !!}">
    {!! Form::label('descriptions_description', $word['title_descriptions_description']) !!}
    <div class="flex-row input">
        @foreach($languages as $language)
            <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                @if(isset($articleAuthor))
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1">{!! $articleAuthor['descriptions'][$language->id]['description'] !!}</textarea>
                @else
                    <textarea class="form-control dynamic-editor" required id="editor-description-{{$language->id}}" placeholder="Username" name="descriptions[{{$language->id}}][description]" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                @endif
            </div>
        @endforeach
    </div>
</div>
