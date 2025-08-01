<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['image']['inTab'] !!}">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="input-group">
        <div class="custom-file image-upload">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            <label for="image" class="custom-file-label"><i class="bi bi-arrow-up-square"></i></label>
            <img src="" alt="Прев’ю" style="max-width: 200px; margin-top: 10px; display: none;">
            {{$manufacturer['image']}}
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label("description_name", $word['title_sort_order']) !!}
    <div class="flex-row w-full">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("description[$language->id][name]", $language->id) !!}
                {!! Form::text("description[$language->id][name]", null, ['class' => 'form-control', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>
<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
</div>
