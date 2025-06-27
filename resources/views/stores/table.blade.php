<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="stores-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Url</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stores as $store)
                <tr>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->url }}</td>
                    <td>{{ $store->created_at }}</td>
                    <td>{{ $store->updated_at }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['stores.destroy', $store->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('stores.show', [$store->id]) }}"
                               class='btn btn-default butt-show btn-xs'>
                                <i class="bi bi-eye-fill fs-40"></i>
                            </a>
                            <a href="{{ route('stores.edit', [$store->id]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>
                            {!! Form::button('<i class="bi bi-trash fs-20"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $stores])
        </div>
    </div>
</div>
