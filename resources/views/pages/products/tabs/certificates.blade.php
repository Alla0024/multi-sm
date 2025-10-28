@php
    $arrData = [
        'certificate' => ['type' => 'pdf', 'name' => 'Інструкції', 'description' => false],
        'sort_order' => ['type' => 'number', 'name' => 'Порядок сортування', 'description' => false],
    ];
@endphp

@include('components.table.table_items', ['inputType' => $arrData, 'data' => $product['certificates'] ?? [], 'search_select_type' => 'certificates', 'name' => 'certificates', 'id_name' => 'id', 'tab' => 'instructions', 'parse' => false])
