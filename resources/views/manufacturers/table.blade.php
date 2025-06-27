<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="manufacturers-table">
            <thead>
            <tr>
                <th>Image</th>
                <th>Sort Order</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($manufacturers as $manufacturer)
                <tr>
                    <td>{{ $manufacturer->image }}</td>
                    <td>{{ $manufacturer->sort_order }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['manufacturers.destroy', $manufacturer->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('manufacturers.show', [$manufacturer->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('manufacturers.edit', [$manufacturer->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $manufacturers])
        </div>
    </div>
</div>
