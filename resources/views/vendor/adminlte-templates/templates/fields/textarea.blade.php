<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane input-block" data-for-tab="main">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', $word['title_{{ $fieldName }}']) !!}
@endif
    <div class="flex-row input">
        <div class="input-group">
            @{!! Form::textarea('{{ $fieldName }}', null, ['class' => ''@php if(isset($options)) { echo htmlspecialchars_decode($options); } @endphp]) !!}
        </div>
    </div>
</div>
