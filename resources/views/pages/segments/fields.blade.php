@dump($segment)

<!-- Name Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('name', 'Назва') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'rows' => 2, 'required' ]) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', $word['title_status']) !!}
    <div class="flex-row input">
        <div class="input-group input-min">
            {!! Form::select('status', ['0' => $word['status_inactive'], '1' => $word['status_active']], null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>



<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::number('sort_order', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
