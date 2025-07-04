<!-- {{ $fieldTitle }} Field -->
<div class="col-sm-12">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', $word['title_{{ $fieldName }}']) !!}
@endif
    <p>@{{ ${!! $config->modelNames->camel !!}->{!! $fieldName !!} }}</p>
</div>
