<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="languages-table">
            <thead>
            <tr>
                <th>Code</th>
                <th>Path</th>
                <th>Status</th>
                <th>Sort Order</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($languages as $language)
                <tr>
                    <td>{{ $language->code }}</td>
                    <td>{{ $language->path }}</td>
                    <td>{{ $language->status }}</td>
                    <td>{{ $language->sort_order }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['languages.destroy', $language->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('languages.show', [$language->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('languages.edit', [$language->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
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
            @include('adminlte-templates::common.paginate', ['records' => $languages])
        </div>
    </div>
</div>
