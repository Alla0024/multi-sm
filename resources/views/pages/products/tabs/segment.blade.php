<!-- Segment Field -->
@include('components.inputs.multi_select', ['name' => 'segments', 'name_input' => 'segment[]', 'value' => $product ?? [], 'url' => 'getSegments', 'tab' => 'segment'])
