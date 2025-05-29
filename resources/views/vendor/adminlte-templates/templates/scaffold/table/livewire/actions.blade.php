<div class='btn-group'>
    <a href="{{ $showUrl }}" class='btn btn-default butt-show btn-xs'>
        <i class="bi bi-eye-fill fs-40"></i>
    </a>
    <a href="{{ $editUrl }}" class='btn btn-default butt-edit btn-xs'>
        <i class="bi bi-pencil fs-40"></i>
    </a>
    <a class='btn btn-danger btn-xs' wire:click="deleteRecord({{ $recordId }})"
       onclick="confirm('Are you sure you want to remove this Record?') || event.stopImmediatePropagation()">
        <i class="bi bi-trash fs-20"></i>
    </a>
</div>
