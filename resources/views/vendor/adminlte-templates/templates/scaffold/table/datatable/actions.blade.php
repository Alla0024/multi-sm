@{!! Form::open(['route' => ['{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.destroy', ${{ $config->primaryName }}], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.show', ${!! $config->primaryName !!}) }}" class='btn btn-default butt-show btn-xs'>
        <i class="bi bi-eye-fill fs-40"></i>
    </a>
    <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.edit', ${!! $config->primaryName !!}) }}" class='btn btn-default butt-edit btn-xs'>
        <i class="bi bi-pencil fs-40"></i>
    </a>
    @{!! Form::button('<i class="bi bi-trash fs-20"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
@if($config->options->localized)
        'onclick' => "return confirm('Are you sure?')"
@else
        'onclick' => 'return confirm("'.__('crud.are_you_sure').'")'
@endif

    ]) !!}
</div>
@{!! Form::close() !!}
