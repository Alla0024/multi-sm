<!-- Image Field -->
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['image']['inTab'] !!}" x-data="manufacture">
    {!! Form::label('image', $word['title_image']) !!}
    <div class="input-group">
        <div class="custom-file image-upload">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            <label for="image" class="custom-file-label"><i class="bi bi-arrow-up-square"></i></label>
            <img src="" alt="Прев’ю" style="max-width: 200px; margin-top: 10px; display: none;">
            {{$manufacturer['image']}}
        </div>
    </div>
    <div class="lfm" data-input="thumbnail" data-preview="holder" data-path="/images/catalog/category/logo_wtm">Обрати</div>
    <input id="thumbnail" type="text" name="filepath">
    <img id="holder" alt="" style="max-width:200px;">
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6 tab-pane" data-for-tab="{!! $fields['sort_order']['inTab'] !!}">
    {!! Form::label("description_name", $word['title_sort_order']) !!}
    <div class="flex-row w-full">
        @foreach($languages as $language)
            <div class="form-group mt-3">
                {!! Form::label("description[$language->id][name]", $language->id) !!}
                {!! Form::text("description[$language->id][name]", null, ['class' => 'form-control', ]) !!}
            </div>
        @endforeach
    </div>
</div>
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
