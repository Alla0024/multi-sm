@php
    $arrData = [
        'similar_id' => ['type' => 'search_select_categories', 'name' => 'Оберіть схожий товар', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
    ]
@endphp
@include('components.table.table_items', ['inputType' => $arrData, 'data' => $product['similarProducts'] ?? [], 'search_select_type' => 'similar_id', 'name' => 'similar_id', 'id_name' => 'similar', 'url' => 'getProducts', 'tab' => 'similar', 'parse' => true])
