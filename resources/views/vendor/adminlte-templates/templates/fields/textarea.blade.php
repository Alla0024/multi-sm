<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane" data-for-tab="@{!! $fields['{{$fieldName}}']['inTab'] !!}">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', $word['title_{{ $fieldName }}']) !!}
@endif
    @{!! Form::textarea('{{ $fieldName }}', null, ['class' => 'form-control'@php if(isset($options)) { echo htmlspecialchars_decode($options); } @endphp]) !!}
</div>
