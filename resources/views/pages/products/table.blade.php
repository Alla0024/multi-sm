<div class="card-body p-0">

    <div class="table-responsive">
        <table class="table" id="products-table">
            <thead>
            <tr>
                @include('components.basic.search')
            </tr>
            </thead>
            <tbody>
{{--            @dump($products[0])--}}
{{--            @dump($stockStatuses)--}}
            @foreach($products as $product)
                <tr>
                    <th>
                        <div class="input-block input-toggle flex">
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox-child" data-content="{{ $product['id']}}" name="input-toggle_{{ $product['id']}}" type="checkbox" role="switch" id="switchCheckChecked_{{ $product['id']}}">
                            </div>
                        </div>
                    </th>

                    @foreach($fields as $index => $field)
                        @if($index == 'status' && $field['inTable'])
                            @if($product[$index] == 1)
                                <td><div class="status_active">{{ $word['status_1'] }}</div></td>
                            @else
                                <td><div class="status_enable">{{ $word['status_0'] }}</div></td>
                            @endif
                        @elseif($index == 'image' && $field['inTable'])
                            <td><img style="width: 140px; border: 0.7px solid rgba(172, 172, 172, 0.20);" src="{{isset($product[$index]) && $product[$index] != '' ? 'https://i.svit-matrasiv.com.ua/images/'.$product[$index] : '/images/common/no_images.png'}}" alt=""></td>
                        @elseif($index == 'manufacturer_id')
                            <td>{{$product['manufacturer']['description']['name']}}</td>
                        @elseif($index == 'category_id')
                            <td>{{$product['category']['description']['name']}}</td>
                        @elseif($index == 'stock_status_id')
                            <td><div style="padding: 4px 10px; width: max-content; color: white; border-radius: 4px; background: {{$word['status_stock_'.$product['stock_status_id']]}}">{{$product['stockStatus']['description']['name']}}</div></td>
                        @elseif($index == 'sort_order')
                            <td>
                                <input type="hidden" data-action="{{ route('change_sort_order') }}" name="product_id" value="{{$product['id']}}">
                                <input class="hide" name="new_value" value="{{ $product[$index] }}">
                                <div class="change-sort-order">{{ $product[$index] }}</div>
                            </td>
                        @else
                             @if($index != 'id' && $field['inTable'])
                                <td>{{ $product[$index] }}</td>
                             @endif
                        @endif
                    @endforeach
                    @if(isset($products))
                        <td style="width: 110px">

                        </td>
                    @endif

                    <td  colspan="3">
                        {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>




                            <a href="{{ route('products.edit', [$product->id]) }}"
                               class='btn btn-default butt-edit btn-xs'>
                                <i class="bi bi-pencil fs-40"></i>
                            </a>

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
            @include('adminlte-templates::common.paginate', ['records' => $products])
        </div>
    </div>
</div>
