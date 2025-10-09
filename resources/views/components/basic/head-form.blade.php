<div class="container-fluid">
    <div class="block-title">
        <div class="edit-title">
            @if(Request::is('*/edit'))
                {{ $word['edit_form'] }}
            @else
                {{ $word['create_form'] }}
            @endif
        </div>
        <div class="edit-desc">
            @if(isset($data))
                @if(isset($data['title']))
                    {{$data['title']}}
                @elseif(isset($data['name']))
                    {{$data['name']}}
                @elseif(isset($data['descriptions'][5]))
                    @if(isset($data['descriptions'][5]['name']))
                        {{$data['descriptions'][5]['name']}}
                    @elseif(isset($data['descriptions'][5]['title']))
                        {{$data['descriptions'][5]['title']}}
                    @endif
                @endif

            @endif
        </div>
    </div>

    <div class="butt">
        {!! Form::submit($word['save'], ['class' => 'btn btn-primary head-submit']) !!}
    </div>
</div>
