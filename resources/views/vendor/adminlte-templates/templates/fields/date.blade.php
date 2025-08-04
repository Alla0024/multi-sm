<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="@{!! $fields['{{$fieldName}}']['inTab'] !!}">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', $word['title_{{ $fieldName }}']) !!}
@endif
    <div class="flex-row input">
        <div class="input-group">
            @{!! Form::date('{{ $fieldName }}', null, ['class' => 'form-control','id'=>'{{ $fieldName }}']) !!}
        </div>
    </div>
</div>

@@push('page_scripts')
    <script type="text/javascript">
        $('#{{ $fieldName }}').datepicker()
    </script>
@@endpush
