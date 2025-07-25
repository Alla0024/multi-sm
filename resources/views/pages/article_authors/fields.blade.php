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
