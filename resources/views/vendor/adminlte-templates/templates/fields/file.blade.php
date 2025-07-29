<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="@{!! $fields['{{$fieldName}}']['inTab'] !!}">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', $word['title_{{ $fieldName }}']) !!}
@endif
    <div class="input-group">
        <div class="custom-file image-upload">
            @{!! Form::file('{{ $fieldName }}', ['class' => 'custom-file-input']) !!}
            <label for="{{ $fieldName }}" class="custom-file-label"><i class="bi bi-arrow-up-square"></i></label>
{{--            @{!! Form::label('{{ $fieldName }}', 'Choose file', ['class' => 'custom-file-label']) !!}--}}
            <img src="" alt="Прев’ю" style="max-width: 200px; margin-top: 10px; display: none;">
        </div>
    </div>
</div>
<div class="clearfix"></div>
