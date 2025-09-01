<!-- 'Boolean {{ $fieldTitle }} Field' checked by default -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', word['title_{{ $fieldName }}']) !!}
@endif
    <label class="checkbox-inline">
    @{!! Form::checkbox('{{ $fieldName }}', 1, true) !!}
    <!-- remove {, true} to make it unchecked by default -->
    </label>
</div>
