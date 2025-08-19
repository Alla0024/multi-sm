{{--<div class="breadcrumb-custom">--}}
{{--    <div class="breadcrumb-item-custom-link">--}}
{{--        <a href="/">--}}
{{--            Головна--}}
{{--        </a>--}}
{{--    </div>--}}

{{--    <div class="breadcrumb-item-custom-arrow"><i class="bi bi-chevron-right fs-20"></i></div>--}}

{{--    <div class="breadcrumb-item-custom-link">--}}
{{--        <a href="#">--}}
{{--            Щось інше--}}
{{--        </a>--}}
{{--    </div>--}}

{{--    <div class="breadcrumb-item-custom-arrow"><i class="bi bi-chevron-right fs-20"></i></div>--}}

{{--    <div class="breadcrumb-item-custom">--}}

{{--            Щось інше--}}

{{--    </div>--}}

{{--</div>--}}

<div class="breadcrumb-custom">
    <div class="breadcrumb-item-custom-link">
        <a href="/">
            Головна
        </a>
    </div>
    @if(!empty($breadcrumbs))
        <div class="breadcrumb-item-custom-arrow"><i class="bi bi-chevron-right fs-20"></i></div>
        <div class="breadcrumb-item-custom-link">
            <a href="{{ route('optionValues.index') }}">
                {!!  $word['option_values'] !!}
            </a>
        </div>
        @foreach($breadcrumbs as $key => $crumb)
                <div class="breadcrumb-item-custom-arrow"><i class="bi bi-chevron-right fs-20"></i></div>
                <div class="breadcrumb-item-custom-link">
                    <a href="{{ route('optionValues.show', ['optionValue' => $crumb['id']]) }}">
                        {{ $crumb['name'] }}
                    </a>
                </div>
        @endforeach
    @endif
</div>
