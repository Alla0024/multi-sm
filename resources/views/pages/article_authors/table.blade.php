<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="article-authors-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            <tr>
                @if(isset($fields))
                    <th></th>
                    @foreach($fields as $index => $field)
                         @if($index != 'id' && $field['inTable'])
                            <th>{{ $word['title_'.$index] }}</th>
                        @endif
                    @endforeach
                @endif
                <th colspan="3">{{ $word['action'] }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articleAuthors as $articleAuthor)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{$articleAuthor['id']}}" name="input-toggle_{{$articleAuthor['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{$articleAuthor['id']}}">
                            </div>
                        </div>
                    </th>
                    @foreach($fields as $index => $field)
                         @if($index != 'id' && $field['inTable'])
                            <td>{{ $articleAuthor[$index] }}</td>
                         @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['articleAuthors.destroy', $articleAuthor->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
{{--                            <a href="{{ route('articleAuthors.show', [$articleAuthor->id]) }}"--}}
{{--                               class='btn btn-default butt-show btn-xs'>--}}
{{--                                <i class="bi bi-eye-fill fs-40"></i>--}}
{{--                            </a>--}}
                            <a href="{{ route('articleAuthors.edit', [$articleAuthor->id]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>
                            {{--  {!! Form::button('<i class="bi bi-trash fs-20"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
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
            @include('adminlte-templates::common.paginate', ['records' => $articleAuthors])
        </div>
    </div>
</div>
