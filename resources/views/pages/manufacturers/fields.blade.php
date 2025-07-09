<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="input-group">
        <div class="custom-file image-upload">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
            <img src="" alt="Прев’ю" style="max-width: 200px; margin-top: 10px; display: none;">
        </div>
    </div>
</div>
<div class="clearfix"></div>


<!-- Sort Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
</div>
