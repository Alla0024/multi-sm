{{--@dump($segment)--}}
{{--@dump($products)--}}
@isset($segment)
    <input type="hidden" name="product_count" value="{{$segment['product_count']}}">
    <input type="hidden" name="type_number" value="{{$segment['type_number']}}">
    <input type="hidden" name="value" value="{{$segment['value']}}">
@endisset
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

<!-- Products Field -->
<div class="form-group col-sm-6 tab-pane input-block" style="flex-direction: column; align-items: start" data-for-tab="product">

    <div class="table-responsive">
        <table class="table" id="segments-table">
            <thead>
            <tr>
                <form class="search-form search-form-product" id="search-form-product" method="GET" action="">
                    <th width="85">
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-father" data-content="" name="input-toggle" type="checkbox" role="switch" id="switchCheckChecked">
                                <i class="bi bi-check-all"></i>
                            </div>
                        </div>
                    </th>

                    <th class="" >
                        <div class="search-name-input">Модель</div>
                        <div class="">
                            <input type="text" name="search_model" id="search_model" placeholder="Пошук по моделі" value="{{ request('search_model') }}">
                        </div>
                    </th>

                    <th class="">
                        <div class="search-name-input">Назва</div>
                        <div class="">
                            <input type="text" name="search_name" id="search_item" placeholder="Пошук по назві" value="{{ request('search_name') }}">
                        </div>
                    </th>

                    <th class="" >
                        <div class="search-name-input">Товари сегменту</div>
                        <div class="">
                            <select id="segment_item"  name="filter_segment" >
                                <option @if(request()->get('filter_segment') == 'all') selected
                                        @endif value="all">Всі</option>
                                <option @if(request()->get('filter_segment') == '1') selected
                                        @endif value="1">Так</option>
                                <option @if(request()->get('filter_segment') == '0') selected
                                        @endif value="0">Ні</option>
                            </select>
                        </div>
                    </th>

                    <th class="" >
                        <div class="search-name-input">Виробники</div>
                        <div class="flex-row input input-block">
                            <div class="input-group input-list-search" style="position: relative;">
                                <input type="hidden" name="search_manufacturer_id" id="manufacturer_id" value="{{request('search_manufacturer_id')}}">
                                <input
                                        class="ignore_form"
                                        name="search_manufacturer_id"
                                        placeholder="Пошук..."
                                        autocomplete="off"
                                        value="{{request('search_manufacturer_id')}}"
                                        data-url="{{route('getManufacturers')}}"
                                        @input="$store.page.searchSelect($event.target)"
                                        @focus="$store.page.searchSelect($event.target)"
                                        custom="true"
                                >
                                <ul class="custom-list hide">

                                </ul>
                                <div class="svg">
                                    <img src="/images/common/arrow_select.png" alt="">
                                </div>
                            </div>
                        </div>
                    </th>

                    <th class="" >
                        <div class="search-name-input">Категорії</div>
                        <div class="flex-row input input-block">
                            <div class="input-group input-list-search" style="position: relative;">
                                <input type="hidden" name="search_category_id" id="category_id" value="{{request('search_category_id')}}">
                                <input
                                        class="ignore_form"
                                        name="search_category_id"
                                        placeholder="Пошук..."
                                        autocomplete="off"
                                        value="{{request('search_category_id')}}"
                                        data-url="{{route('getCategories')}}"
                                        @input="$store.page.searchSelect($event.target)"
                                        @focus="$store.page.searchSelect($event.target)"
                                        custom="true"
                                >
                                <ul class="custom-list hide">

                                </ul>
                                <div class="svg">
                                    <img src="/images/common/arrow_select.png" alt="">
                                </div>
                            </div>
                        </div>
                    </th>

                    <th class="" style="width: 132px">
                        <div class="search-name-input">Статус</div>
                        <div class="">
                            <select class="" name="filter_status" id="status_item"  aria-describedby="select-addon">
                                <option value="all" @if(request('filter_status') == 'all') selected @endif >Всі</option>
                                <option value="1" @if(request('filter_status') == '1') selected @endif>Увімкнено</option>
                                <option value="0" @if(request('filter_status') == '0') selected @endif>Вимкнено</option>
                            </select>
                        </div>
                    </th>

                    <th class="" >
                        <div class="search-name-input">Статус</div>
                        <div class="">
                            <select class="" name="filter_stock_status" id="stock_status_item"  aria-describedby="select-addon">
                                <option {{ !request()->get('filter_stock_status') ? 'selected' : '' }} value="">Всі</option>
                                @foreach($stockStatuses as $stock_status)
                                    <option {{ request()->get('filter_stock_status') == $stock_status->id ? 'selected' : '' }} value="{{ $stock_status->id }}">
                                        {{ $stock_status->description->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </th>

                    <th class="" >
                        <div class="search-name-input">Порядок сортування</div>
                    </th>

                    <th class="butt-action action-item">
                        <div class="butt-action-block">

                            <div class="name-action">
                                Дії
                            </div>

                            <div class="action-block-search">

                                <div class="btn btn-primary search-change-butt-product" style="margin: 0 auto 6px; width: 100%;">
                                    <svg style="margin-right: 4px; margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                        <path d="M10.6429 10.57L8.113 8.04055C8.84627 7.16021 9.21192 6.03106 9.13388 4.888C9.05583 3.74494 8.54011 2.67596 7.69399 1.90345C6.84787 1.13094 5.7365 0.714377 4.59107 0.740408C3.44564 0.76644 2.35434 1.23307 1.54419 2.04322C0.734043 2.85337 0.267417 3.94467 0.241385 5.0901C0.215353 6.23553 0.63192 7.3469 1.40443 8.19302C2.17694 9.03913 3.24591 9.55486 4.38898 9.6329C5.53204 9.71094 6.66119 9.34529 7.54153 8.61202L10.0709 11.1419C10.1085 11.1795 10.1531 11.2093 10.2022 11.2296C10.2512 11.2499 10.3038 11.2604 10.3569 11.2604C10.41 11.2604 10.4626 11.2499 10.5117 11.2296C10.5608 11.2093 10.6054 11.1795 10.6429 11.1419C10.6805 11.1044 10.7103 11.0598 10.7306 11.0107C10.7509 10.9617 10.7614 10.9091 10.7614 10.856C10.7614 10.8028 10.7509 10.7502 10.7306 10.7012C10.7103 10.6521 10.6805 10.6075 10.6429 10.57ZM1.05984 5.19686C1.05984 4.47733 1.27321 3.77396 1.67296 3.1757C2.0727 2.57743 2.64088 2.11114 3.30564 1.83579C3.97039 1.56044 4.70187 1.4884 5.40757 1.62877C6.11327 1.76914 6.7615 2.11563 7.27028 2.62441C7.77906 3.13319 8.12555 3.78142 8.26592 4.48712C8.40629 5.19282 8.33425 5.9243 8.0589 6.58906C7.78355 7.25381 7.31726 7.82199 6.71899 8.22174C6.12073 8.62148 5.41736 8.83485 4.69783 8.83485C3.73331 8.83378 2.80859 8.45015 2.12657 7.76812C1.44455 7.0861 1.06091 6.16138 1.05984 5.19686Z" fill="white"/>
                                    </svg>{{ $word['search_change'] }}
                                </div>

                                <div type="" style="margin: 0 auto 6px; width: 100%;" class="btn btn-primary  search-change-butt"
                                                 id="add_product_to_segment">Додати
                                </div>

                                <div type="" style="width: 100%;" class="btn btn-primary  search-change-butt"
                                        id="remove_product_from_segment">Видалити
                                </div>

                                <a class="cast-butt" href="{{ request()->url() }}">
                                    <svg style="margin-right: 4px; margin-top: 2px" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                        <path d="M9.85348 9.14602C9.89993 9.19247 9.93678 9.24762 9.96192 9.30831C9.98706 9.36901 10 9.43406 10 9.49975C10 9.56544 9.98706 9.63049 9.96192 9.69119C9.93678 9.75188 9.89993 9.80703 9.85348 9.85348C9.80703 9.89993 9.75188 9.93678 9.69119 9.96192C9.63049 9.98706 9.56544 10 9.49975 10C9.43406 10 9.36901 9.98706 9.30831 9.96192C9.24762 9.93678 9.19247 9.89993 9.14602 9.85348L5 5.70683L0.85398 9.85348C0.760165 9.9473 0.632925 10 0.50025 10C0.367576 10 0.240335 9.9473 0.14652 9.85348C0.0527047 9.75966 2.61533e-09 9.63242 0 9.49975C-2.61533e-09 9.36707 0.0527047 9.23983 0.14652 9.14602L4.29316 5L0.14652 0.85398C0.0527047 0.760165 0 0.632925 0 0.50025C0 0.367576 0.0527047 0.240335 0.14652 0.14652C0.240335 0.0527047 0.367576 0 0.50025 0C0.632925 0 0.760165 0.0527047 0.85398 0.14652L5 4.29316L9.14602 0.14652C9.23983 0.0527047 9.36707 -2.61533e-09 9.49975 0C9.63242 2.61533e-09 9.75966 0.0527047 9.85348 0.14652C9.9473 0.240335 10 0.367576 10 0.50025C10 0.632925 9.9473 0.760165 9.85348 0.85398L5.70683 5L9.85348 9.14602Z" fill="#81A4FF"/>
                                    </svg>
                                    {{ $word['cancel'] }}
                                </a>

                            </div>
                        </div>
                    </th>
                    @if(request()->has('perPage'))
                        <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                    @endif
                </form>
            </tr>
            </thead>

            <tbody>
            @isset($products)
                @foreach($products as $product)
                    <tr @if($product->stock_status_id==9)style="background: #9a9ea4" @endif>
                        <th>
                            <div class="input-block input-toggle flex">
                                <div class="form-check form-switch">
                                    <input class="form-check-input " data-content="{{ $product['id']}}" name="input-toggle_{{ $product['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{ $product['id']}}">
                                </div>
                            </div>
                        </th>

                        <td>{{ $product->article }}</td>

                        <td>{{ $product->description->name }}</td>

                        <td width="150px">{{ $product->manufacturer->description->name }}</td>

                        <td>{{ $product->manufacturer->description->name }}</td>

                        <td>{{ $product->category->description->name }}</td>

                        <td>
                            @if($product->status == 1)
                                <div class="status_active">{{ $word['status_1'] }}</div>
                            @else
                                <div class="status_enable">{{ $word['status_0'] }}</div>
                            @endif
                        </td>

                        <td>
                            <div style="padding: 4px 10px; width: max-content; color: white; border-radius: 4px; background: {{$word['status_stock_'.$product['stock_status_id']]}}">{{$stockStatusesDescription[$product->stock_status_id]['description']['name']}}</div>
                        </td>

                        <td class="sort-order">{{ $product->sort_order }}</td>

                        <td class="text-center">
                        </td>
                    </tr>
                @endforeach
            @endisset

            </tbody>

        </table>
    </div>
    @isset($products)
        <div class="card-footer clearfix">
            <div class="float-right">
                @include('adminlte-templates::common.paginate', ['records' => $products])
            </div>
        </div>
    @endisset
</div>


<script>

    function applyFilters() {
        const queryParams = new URLSearchParams(window.location.search);

        queryParams.set('search_model', document.querySelector('#search_model')?.value || '');
        queryParams.set('search_name', document.querySelector('#search_item')?.value || '');
        queryParams.set('filter_segment', document.querySelector('#segment_item')?.value || '');
        queryParams.set('search_manufacturer_id', document.querySelector('#manufacturer_id')?.value || '');
        queryParams.set('search_category_id', document.querySelector('#category_id')?.value || '');
        queryParams.set('filter_status', document.querySelector('#status_item')?.value || '');
        queryParams.set('filter_stock_status', document.querySelector('#stock_status_item')?.value || '');

        const newUrl = window.location.pathname.replace(/\/+$/, '') + '/?' + queryParams.toString();
        window.location.href = newUrl;
    }

    document.querySelector('.search-change-butt-product').addEventListener('click', applyFilters)

    @isset($products)
        document.querySelector('#add_product_to_segment').addEventListener('click', (e) => {
            e.preventDefault();

            const isCheckedAll = document.querySelector('#switchCheckChecked')?.checked || false;

            const formData = new FormData();
            formData.append('segment_id', '{{ $segment['id'] ?? '' }}');

            if (isCheckedAll) {
                axios.post('{{ route('addFilteredProductsToSegment', ['segmentId' => ($segment['id'] ?? '')]) }}', formData)
                    .then(r => console.log(r))
                    .catch(e => console.error(e));
            } else {

                const checkItems = document.querySelectorAll('.form-check-input');
                checkItems.forEach(item => {
                    if (item.checked) {
                        formData.append('product_ids[]', item.dataset.content);
                    }
                });

                axios.post('{{ route('addProductToSegment') }}', formData)
                    .then(r => console.log(r))
                    .catch(e => console.error(e));
            }
        });

        document.querySelector('#remove_product_from_segment').addEventListener('click', (e) => {
            e.preventDefault();

            const isCheckedAll = document.querySelector('#switchCheckChecked')?.checked || false;

            const formData = new FormData();
            formData.append('segment_id', '{{ $segment['id'] ?? '' }}');

            if (isCheckedAll) {
                axios.post('{{ route('removeFilteredProductsFromSegment', ['segmentId' => ($segment['id'] ?? '')])}}', formData)
                    .then(r => console.log(r))
                    .catch(e => console.error(e));
            } else {

                const checkItems = document.querySelectorAll('.form-check-input');
                checkItems.forEach(item => {
                    if (item.checked) {
                        formData.append('product_ids[]', item.dataset.content);
                    }
                });

                axios.post('{{ route('removeProductFromSegment') }}', formData)
                    .then(r => console.log(r))
                    .catch(e => console.error(e));
            }
        });
    @endisset
</script>
