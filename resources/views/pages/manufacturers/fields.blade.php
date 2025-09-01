<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['image']['inTab'] !!}" x-data="manufacture">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="input-group">
        <div class="custom-file image-upload">
{{--            {!! Form::file('image', ['class' => 'custom-file-input']) !!}--}}
            <label for="image" class="custom-file-label lfm" data-input="thumbnail" data-preview="holder" data-path=""><i class="bi bi-arrow-up-square"></i></label>
            <input id="thumbnail" type="hidden" name="image" value="{{$manufacturer['image'] ?? ''}}">
            <img class="hide @if(isset($manufacturer['image'])) show @endif " src="{{$manufacturer['image'] ?? ''}}" id="holder" alt="Прев’ю" style="max-width: 200px;">

        </div>
    </div>
{{--    <div class="" >Обрати</div>--}}

{{--    <img  alt="" style="max-width:200px;">--}}
</div>
<div class="clearfix"></div>

<!-- Sort Order Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label('sort_order', $word['title_sort_order']) !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control', 'required']) !!}
</div>

<script>
    document.addEventListener('alpine:init', ()=>{
        Alpine.data('manufacture', () => ({
            // open(el){
            //     filemanager('image', {
            //         prefix: '/filemanager'
            //     });
            // },
        }))
    })
</script>
