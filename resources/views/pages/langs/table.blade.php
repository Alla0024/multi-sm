<div class="card-body p-0">
    <form class="search-form" method="GET" action="">
        @foreach($fields as $field)
            <div class="">
                <lable for="{{ $field }}">{{ $word['title_'.$field] }}</lable>
                <input type="text" name="{{ $field }}" placeholder="{{ ucfirst(str_replace('_', ' ', $field)) }}" value="{{ request($field) }}">
            </div>
        @endforeach


        <div class="butt-action">
            <button class="btn btn-primary" type="submit">{{ $word['search'] }}</button>
            <a href="http://multi">{{ $word['cancel'] }}</a>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table" id="langs-table">
            <thead>
            <tr>
                <th>Code</th>
                <th>Path</th>
                <th>Status</th>
                <th>Sort Order</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th colspan="3">crud.action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($langs as $lang)
                <tr>

                    <td>{{ $lang->code }}</td>
                    <td>{{ $lang->path }}</td>
                    <td>{{ $lang->status }}</td>
                    <td>{{ $lang->sort_order }}</td>
                    <td>{{ $lang->created_at }}</td>
                    <td>{{ $lang->updated_at }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['langs.destroy', $lang->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('langs.show', [$lang->id]) }}"
                               class='btn btn-default butt-show btn-xs'>
                                <i class="bi bi-eye-fill fs-40"></i>
                            </a>
                            <a href="{{ route('langs.edit', [$lang->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $langs])
        </div>
    </div>
</div>
