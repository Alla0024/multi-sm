

@php
    $arrDataTop = [
        'filling_id' => ['type' => 'search_select_categories', 'name' => 'Оберіть наповнення', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
    ];
@endphp

@include('components.table.table_items', ['inputType' => $arrDataTop, 'data' => $product['filling'] ?? [], 'search_select_type' => 'filling_id', 'name' => 'filling', 'id_name' => 'id', 'url' => 'getFilters', 'tab' => 'filling', 'parse' => true])
