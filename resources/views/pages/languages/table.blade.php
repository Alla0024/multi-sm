<div class="card-body p-0">
    <form class="search-form" method="GET" action="">
        @foreach($fields as $field)
             @if(isset($field['searchable']) && $field['searchable'])
                <div class="">
                    <lable for="{{ $field['name'] }}">{{ $word['title_'.$field['name']] }}</lable>
                    <input type="text" name="{{ $field['name'] }}" placeholder="{{ ucfirst(str_replace('_', ' ', $field['name'])) }}" value="{{ request($field['name']) }}">
                </div>
            @endif
        @endforeach


        <div class="butt-action">
            <button class="btn btn-primary" type="submit">{{ $word['search'] }}</button>
            <a href="http://multi">{{ $word['cancel'] }}</a>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table" id="languages-table">
            <thead>
            <tr>
                @foreach($fields as $field)
                     @if($field['name'] != 'id')
                        <th>{{ $word['title_'.$field['name']] }}</th>
                    @endif
                @endforeach

                <th colspan="3">{{ $word['action'] }}</th>
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
                               class='btn btn-default butt-show btn-xs'>
                                <i class="bi bi-eye-fill fs-40"></i>
                            </a>
                            <a href="{{ route('languages.edit', [$language->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $languages])
        </div>
    </div>
</div>
