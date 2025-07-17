<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-12 tab-pane" data-for-tab="@{!! $fields['{{$fieldName}}']['inTab'] !!}">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}'), ['class' => 'form-check-label']) !!}
@else
    @{!! Form::label('{{ $fieldName }}', $word['title_{{ $fieldName }}'], ['class' => 'form-check-label']) !!}
@endif
    {!! $radioButtons !!}
</div>
