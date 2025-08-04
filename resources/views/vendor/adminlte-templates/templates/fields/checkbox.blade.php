<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="@{!! $fields['{{$fieldName}}']['inTab'] !!}">
    <div class="form-check">
        @{!! Form::hidden('{{ $fieldName }}', 0, ['class' => 'form-check-input']) !!}
        @{!! Form::checkbox('{{ $fieldName }}', '{{ $checkboxVal }}', null, ['class' => 'form-check-input']) !!}
        @{!! Form::label('{{ $fieldName }}', $word['title_{{ $fieldName }}'], ['class' => 'form-check-label']) !!}
    </div>
</div>
