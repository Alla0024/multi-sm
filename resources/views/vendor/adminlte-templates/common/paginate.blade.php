<div class="row">
    @if(method_exists($records, 'appends'))
        {!! $records->appends(request()->all())->links() !!}
    @endif
</div>
