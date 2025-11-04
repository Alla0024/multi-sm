{{--@dump($saleGroup)--}}
{{--@dump($sales[0])--}}
{{--@dump($bonusPrograms[0])--}}
{{--@dump($promoCodeGroups[0])--}}

<!-- Name Fields -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('descriptions_name', 'Назва') !!}
    <div class="flex-row input lang-block">
        @foreach($languages as $language)
            <div class="input-group mt-3 input-min">
                <span class="input-group-text" id="basic-addon1">{!! $word[$language->id] !!}</span>
                {!! Form::text("descriptions[$language->id][name]", null, ['class' => '', 'required']) !!}
            </div>
        @endforeach
    </div>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('status', 'Статус групи акцій') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('status', ['0' => 'Вимкнено' , '1' => 'Увімкнено'], null, ['class' => 'form-control', 'required']) !!}

        </div>
    </div>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 tab-pane input-block" data-for-tab="main">
    {!! Form::label('type', 'Статус групи акцій') !!}
    <div class="flex-row input input-min">
        <div class="input-group">
            {!! Form::select('type', ['0' => 'Множення' , '1' => 'Пріоритет', '2' => 'Максимум'], null, ['class' => 'form-control', 'required']) !!}
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


@include('pages.sale_groups.tabs.sale_table', ['tab' => 'sales', 'data' => $saleGroup['sales'], 'name' => 'sales', 'dataItems' => $sales])

@include('pages.sale_groups.tabs.sale_table', ['tab' => 'bonus_programs', 'data' => $saleGroup['bonusPrograms'], 'name' => 'bonus_programs', 'dataItems' => $bonusPrograms])

@include('pages.sale_groups.tabs.sale_table', ['tab' => 'promo_code_group', 'data' => $saleGroup['promoCodeGroups'], 'name' => 'promo_code_groups', 'dataItems' => $promoCodeGroups])

