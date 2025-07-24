<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="article-authors-table">
            <thead>
            <tr>
                <form class="search-form" method="GET" action="">
                    @if(isset($fields))
                        @foreach($fields as $index => $field)
                            @if($index != 'id' && $field['inTable'])
                                <th class="">
                                    @if(isset($field['searchable']) && $field['searchable'])
                                        <div class="">
                                            
                                            <input type="text" name="{{ $index }}" placeholder="{{ $word['search_'.$index] }}" value="{{ request($index) }}">
                                        </div>
                                    @endif
                                </th>
                            @endif
                        @endforeach
                    @endif
                    <th class="butt-action action-item">
                        <span class="hide">article-authors</span>
                        <button class="btn btn-primary" type="submit" style="margin: 0 auto 6px">{{ $word['search'] }}</button>
                        <a href="{{ route('articleAuthors.index') }}">{{ $word['cancel'] }}</a>
                    </th>
                </form>
            </tr>
            <tr>
                @if(isset($fields))
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


                    @foreach($fields as $index => $field)
                         @if($index != 'id' && $field['inTable'])
                            <td>{{ $articleAuthor[$index] }}</td>
                         @endif
                    @endforeach

                    <td  colspan="3">
                        {!! Form::open(['route' => ['articleAuthors.destroy', $articleAuthor->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('articleAuthors.show', [$articleAuthor->id]) }}"
                               class='btn btn-default butt-show btn-xs'>
                                <i class="bi bi-eye-fill fs-40"></i>
                            </a>
                            <a href="{{ route('articleAuthors.edit', [$articleAuthor->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $articleAuthors])
        </div>
    </div>
</div>
