<!-- {{ $fieldName }} Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="@{!! $fields['{{$fieldName}}']['inTab'] !!}">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', $word['title_{{ $fieldName }}']) !!}
@endif
    @{!! Form::password('{{ $fieldName }}', ['class' => 'form-control'@php if(isset($options)) { echo htmlspecialchars_decode($options); } @endphp]) !!}
</div>
