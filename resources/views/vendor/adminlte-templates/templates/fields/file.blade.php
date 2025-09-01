<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', $word['title_{{ $fieldName }}']) !!}
@endif
    <div class="flex-row input">
        <div class="input-group">
            <div class="custom-file image-upload">
                @{!! Form::file('{{ $fieldName }}', ['class' => 'custom-file-input']) !!}

    {{--            @{!! Form::label('{{ $fieldName }}', 'Choose file', ['class' => 'custom-file-label']) !!}--}}
                <img src="" alt="Прев’ю" style="max-width: 200px; margin-top: 10px; display: none;">
                <label for="{{ $fieldName }}" class="custom-file-label"><i class="bi bi-arrow-up-square"></i></label>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
