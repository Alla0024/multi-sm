{{--@dump($product)--}}
{{--@dump($product['productOptions'])--}}
{{--@dump($options)--}}
{{--@dump($product['options'][0])--}}
{{--@dump($options[16])--}}

<!-- Main tab -->
@include('pages.products.tabs.main')

<!-- Data tab -->
@include('pages.products.tabs.data')

<!-- Connections tab -->
@include('pages.products.tabs.connections')

<!-- Attributes tab -->
@include('pages.products.tabs.attributes')

<!-- Images tab -->
@include('pages.products.tabs.images')

<!-- Video tab -->
@include('pages.products.tabs.video')

<!-- Options tab -->
@include('pages.products.tabs.options')

<!-- Kit tab -->
@if(isset($product['kit']))
@include('pages.products.tabs.kit')
@endif

<!-- Certificates tab -->
@include('pages.products.tabs.certificates')

<!-- Count tab -->
@include('pages.products.tabs.count')

<!-- Filling tab -->
@include('pages.products.tabs.filling')

<!-- Segment tab -->
@include('pages.products.tabs.segment')

<!-- Similar tab -->
@include('pages.products.tabs.similar')


