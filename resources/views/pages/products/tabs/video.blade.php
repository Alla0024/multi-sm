@php
    $arrData = [
        'product_id' => ['type' => 'imageVideo', 'name' => 'Зображення', 'description' => false],
        'url' => ['type' => 'string', 'name' => 'посилання Відео-youtube', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
    ];
@endphp

@include('components.table.table_items', ['inputType' => $arrData, 'data' => $product['videos'] ?? [], 'search_select_type' => 'videos', 'name' => 'videos', 'id_name' => 'id', 'tab' => 'video', 'parse' => false])
