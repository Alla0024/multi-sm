<div class="card-body p-0">
    <form class="search-form" method="GET" action="">

      <div class="">
          <input type="number" name="sort_order" placeholder="Порядок (sort_order)" value="{{ request('sort_order') }}">
      </div>

      <div class="butt-action">
          <button class="btn btn-primary" type="submit">Пошук</button>
          <a href="{{ url()->current() }}">Скинути</a>
      </div>

    </form>
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
                               class='btn btn-default butt-show btn-xs'>
                                <i class="bi bi-eye-fill fs-40"></i>
                            </a>
                            <a href="{{ route('manufacturers.edit', [$manufacturer->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $manufacturers])
        </div>
    </div>
</div>
