@php
    $arrData = [
        'kit_product_id' => ['type' => 'search_select_categories', 'name' => 'Оберіть схожий товар', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
        'quantity' => ['type' => 'number', 'name' => 'Кількість', 'description' => false],
    ]
@endphp
@include('components.table.table_items', ['inputType' => $arrData, 'data' => $product['kits'] ?? [], 'search_select_type' => 'kit_product_id', 'name' => 'product_kit', 'id_name' => 'kit_product_id', 'url' => 'getProducts', 'tab' => 'kit', 'parse' => true])
