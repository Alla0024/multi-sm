<!-- Avatar Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['avatar']['inTab'] !!}">
    {!! Form::label('avatar', $word['title_avatar']) !!}
    {!! Form::text('avatar', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>


<!-- Date Of Birth Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['date_of_birth']['inTab'] !!}">
    {!! Form::label('date_of_birth', $word['title_date_of_birth']) !!}
    {!! Form::text('date_of_birth', null, ['class' => 'form-control','id'=>'date_of_birth']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date_of_birth').datepicker()
    </script>
@endpush

<!-- SEO url -->
<div class="form-group col-sm-12 col-lg-12 tab-pane" data-for-tab="{!! $fields['path']['inTab'] !!}">
    {!! Form::label('path', $word['title_path']) !!}
    {!! Form::text('path', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Facebook Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane" data-for-tab="{!! $fields['facebook']['inTab'] !!}">
    {!! Form::label('facebook', $word['title_facebook']) !!}
    {!! Form::text('facebook', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Instagram Field -->
<div class="form-group col-sm-12 col-lg-12 tab-pane" data-for-tab="{!! $fields['instagram']['inTab'] !!}">
    {!! Form::label('instagram', $word['title_instagram']) !!}
    {!! Form::text('instagram', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Title Fields -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['title']['inTab'] !!}">
    {!! Form::label('descriptions_title', $word['title_descriptions_title']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][title]", $language->id, ['class' => 'form-label']) !!}
                {!! Form::text("descriptions[$language->id][title]", null, ['class' => 'form-control', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['title']['inTab'] !!}">
    {!! Form::label('descriptions_name', $word['title_descriptions_name']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][name]", $language->id, ['class' => 'form-label']) !!}
                {!! Form::textarea("descriptions[$language->id][name]", null, ['class' => 'form-control', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Description Fields -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['title']['inTab'] !!}">
    {!! Form::label('descriptions_description', $word['title_descriptions_description']) !!}

    <div class="flex-row">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("descriptions[$language->id][description]", $language->id, ['class' => 'form-label']) !!}
                {!! Form::textarea("descriptions[$language->id][description]", null, ['class' => 'form-control', 'rows' => 2, 'required']) !!}
            </div>
        @endforeach
    </div>
</div>
