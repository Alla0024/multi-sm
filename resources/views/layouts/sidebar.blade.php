@php
    $adminPath = env('ADMIN_DASHBOARD', 'aikqweu')
@endphp

@isset($word)
    <div class="sidebar-customer" :class="{'sidebar_hide':Alpine.store('page').sidebar_hide}">

    <div class="logo">
        <img width="40" :class="{'hide_opacity': Alpine.store('page').sidebar_hide}" :src="$store.page.theme == 'dark' ? '/images/common/logo_new_light.png' : '/images/common/logo_new_light.png'" alt="">
    </div>

    <div class="items-link">

        <a href="{{asset('/'.$adminPath)}}" class="item {{ Request::is($adminPath.'/dashboard*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-houses-fill fs-20"></i></div>
            <div class="name">Головна</div>
        </a>

{{--        <div class="item-list" x-data="{open_list: {{ Request::is($adminPath.'/example*') ? 'true' : 'false' }}}">--}}
{{--            <div class="item {{ Request::is($adminPath.'/example*') ? 'active' : '' }}" @click="open_list = !open_list">--}}
{{--                <div class="icon"><i class="bi bi-gear-fill fs-20"></i></div>--}}
{{--                <div class="name">Example</div>--}}
{{--                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>--}}
{{--            </div>--}}
{{--            <div class="list" :class="{'list-open': open_list}">--}}
{{--                <a class="item {{ Request::is($adminPath.'/example') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/example')}}">Form</a>--}}
{{--                <a class="item {{ Request::is($adminPath.'/example/edit*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/example/edit')}}">Inputs</a>--}}
{{--            </div>--}}
{{--        </div>--}}

        <a href="{{ route('manufacturers.index') }}" class="item {{ Request::is($adminPath.'/manufacturers*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-bootstrap fs-20"></i></div>
            <div class="name">{{$word['menu_manufacturers']}}</div>
        </a>

        <a href="{{ route('categories.index') }}" class="item {{ Request::is($adminPath.'/categories*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-columns-gap fs-20"></i></div>
            <div class="name">{{$word['menu_categories']}}</div>
        </a>

        <a href="{{ route('filters.index') }}" class="item {{ Request::is($adminPath.'/filters*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-filter fs-20"></i></div>
            <div class="name">{{$word['menu_filters']}}</div>
        </a>

        <div class="item-list" x-data="{open_list: {{ Request::is($adminPath.'/option*') ? 'true' : 'false' }}}">
            <div class="item {{ Request::is($adminPath.'/option*') ? 'active' : '' }}" @click="open_list = !open_list">
                <div class="icon"><i class="bi bi-collection-fill fs-20"></i></div>
                <div class="name">{{$word['menu_option']}}</div>
                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>
            </div>
            <div class="list" :class="{'list-open': open_list}">
                <a class="item {{ Request::is($adminPath.'/options*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/options')}}">{{$word['menu_options']}}</a>
                <a class="item {{ Request::is($adminPath.'/optionValues*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/optionValues')}}">{{$word['menu_option_values']}}</a>
            </div>
        </div>

        <div class="item-list" x-data="{open_list: {{ Request::is([$adminPath.'/news', $adminPath.'/news/*', $adminPath.'/information*', $adminPath.'/articleAuthors*']) ? 'true' : 'false' }}}">
            <div class="item {{ Request::is([$adminPath.'/news', $adminPath.'/news/*', $adminPath.'/information*', $adminPath.'/articleAuthors*']) ? 'active' : '' }}" @click="open_list = !open_list">
                <div class="icon"><i class="bi bi-stickies fs-20"></i></div>
                <div class="name">{{$word['menu_new']}}</div>
                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>
            </div>
            <div class="list" :class="{'list-open': open_list}">
                <a class="item {{ Request::is($adminPath.'/information*') ? 'active' : '' }}" href="{{ route('information.index') }}">{{$word['menu_informations']}}</a>
                <a class="item {{ Request::is([$adminPath.'/news', $adminPath.'/news/*']) ? 'active' : '' }}" href="{{ route('news.index') }}">{{$word['menu_news']}}</a>
                <a class="item {{ Request::is($adminPath.'/articleAuthors*') ? 'active' : '' }}" href="{{ route('articleAuthors.index') }}">{{$word['menu_article_authors']}}</a>
                <a class="item {{ Request::is($adminPath.'/newsCategories*') ? 'active' : '' }}" href="{{ route('newsCategories.index') }}">News category</a>
            </div>
        </div>

        <div class="item-list" x-data="{open_list: {{ Request::is($adminPath.'/attribute*') ? 'true' : 'false' }}}">
            <div class="item {{ Request::is($adminPath.'/attribute*') ? 'active' : '' }}" @click="open_list = !open_list">
                <div class="icon"><i class="bi bi-circle-square fs-20"></i></div>
                <div class="name">{{$word['menu_attribute']}}</div>
                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>
            </div>
            <div class="list" :class="{'list-open': open_list}">
{{--                <a class="item {{ Request::is($adminPath.'/attributes*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/attributes')}}">{{$word['menu_attribute']}}</a>--}}
                <a class="item {{ Request::is($adminPath.'/attributeGroups*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/attributeGroups')}}">{{$word['menu_attribute']}}</a>
                <a class="item {{ Request::is($adminPath.'/attributeIcons*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/attributeIcons')}}">{{$word['menu_attribute_icons']}}</a>
                <a class="item {{ Request::is($adminPath.'/attributeWords*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/attributeWords')}}">{{$word['menu_attribute_words']}}</a>
            </div>
        </div>

        <a href="{{ route('fillings.index') }}" class="item {{ Request::is($adminPath.'/fillings*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-border-width fs-20"></i></div>
            <div class="name">{{$word['menu_filling']}}</div>
        </a>

        <a href="{{ route('products.index') }}" class="item {{ Request::is($adminPath.'/products*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-cart2 fs-20"></i></div>
            <div class="name">{{$word['menu_products']}}</div>
        </a>

        <a href="{{ route('productReviews.index') }}" class="item {{ Request::is($adminPath.'/productReviews*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-postcard-fill fs-20"></i></div>
            <div class="name">{{$word['menu_reviews']}}</div>
        </a>

        <a href="{{ route('bannerGroups.index') }}" class="item {{ Request::is($adminPath.'/bannerGroups*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-images fs-20"></i></div>
            <div class="name">Банери</div>
        </a>

        <div class="item-list" x-data="{open_list: {{ Request::is([$adminPath.'/segments*', $adminPath.'/bonusPrograms*', $adminPath.'/promoCodes*', $adminPath.'/promoCodeGroups*', $adminPath.'/sales*', $adminPath.'/saleGroups*']) ? 'true' : 'false' }}}">
            <div class="item {{ Request::is([$adminPath.'/segments*', $adminPath.'/bonusPrograms*', $adminPath.'/promoCodes*', $adminPath.'/promoCodeGroups*', $adminPath.'/sales*', $adminPath.'/saleGroups*']) ? 'active' : '' }}" @click="open_list = !open_list">
                <div class="icon"><i class="bi bi-percent fs-20"></i></div>
                <div class="name">Налаштування знижок</div>
                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>
            </div>
            <div class="list" :class="{'list-open': open_list}">
                <a class="item {{ Request::is($adminPath.'/sales*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/sales')}}">Акції</a>
                <a class="item {{ Request::is($adminPath.'/promoCodes*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/promoCodes')}}">Промокоди</a>
                <a class="item {{ Request::is($adminPath.'/promoCodeGroups*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/promoCodeGroups')}}">Група промокодів</a>
                <a class="item {{ Request::is($adminPath.'/bonusPrograms*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/bonusPrograms')}}">Бонусні програми</a>
                <a class="item {{ Request::is($adminPath.'/segments*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/segments')}}">Сегменти</a>
                <a class="item {{ Request::is($adminPath.'/saleGroups*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/saleGroups')}}">Дерево знижок</a>

            </div>
        </div>

        <a href="{{ route('vacancies.index') }}" class="item {{ Request::is($adminPath.'/vacancies*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-person-vcard fs-20"></i></div>
            <div class="name">{{$word['menu_vacancies']}}</div>
        </a>

        <a href="{{ route('shops.index') }}" class="item {{ Request::is($adminPath.'/shops*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-buildings fs-20"></i></div>
            <div class="name">{{$word['menu_shops']}}</div>
        </a>

        <div class="item-list" x-data="{open_list: {{ Request::is($adminPath.'/newsletters*') ? 'true' : 'false' }}}">
            <div class="item {{ Request::is($adminPath.'/newsletters*') ? 'active' : '' }}" @click="open_list = !open_list">
                <div class="icon"><i class="bi bi-telephone fs-20"></i></div>
                <div class="name">{{$word['menu_service']}}</div>
                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>
            </div>
            <div class="list" :class="{'list-open': open_list}">
                <a class="item {{ Request::is($adminPath.'/newsletters*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/newsletters')}}">{{$word['menu_newsletters']}}</a>
            </div>
        </div>

        <div class="item-list" x-data="{open_list: {{ Request::is($adminPath.'/clients*') ? 'true' : 'false' }}}">
            <div class="item {{ Request::is($adminPath.'/clients*') ? 'active' : '' }}" @click="open_list = !open_list">
                <div class="name">CRM</div>
                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>
            </div>
            <div class="list" :class="{'list-open': open_list}">
                <a class="item {{ Request::is($adminPath.'/clients*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/clients')}}">Клієнти</a>
            </div>
        </div>

        <div class="item-list" x-data="{open_list: {{ Request::is([$adminPath.'/currencies', $adminPath.'/stockStatuses*', $adminPath.'/individualEntrepreneurs*']) ? 'true' : 'false' }}}">
            <div class="item {{ Request::is([$adminPath.'/currencies', $adminPath.'/stockStatuses*', $adminPath.'/individualEntrepreneurs*']) ? 'active' : '' }}" @click="open_list = !open_list">
                <div class="icon"><i class="bi bi-sliders2 fs-20"></i></div>
                <div class="name">Налаштування</div>
                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>
            </div>
            <div class="list" :class="{'list-open': open_list}">
                <a class="item {{ Request::is($adminPath.'/individualEntrepreneurs*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/individualEntrepreneurs')}}">ФОПи</a>
                <a class="item {{ Request::is($adminPath.'/currencies*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/currencies')}}">Валюти</a>
                <a class="item {{ Request::is($adminPath.'/stockStatuses*') ? 'active' : '' }}" href="{{asset('/'.$adminPath.'/stockStatuses')}}">Статуси товарів</a>
            </div>
        </div>

    </div>
</div>
@endisset



{{--<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
{{--    <div class="container">--}}
{{--        <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--            {{ config('app.name', 'Laravel') }}--}}
{{--        </a>--}}
{{--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
{{--            <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}

{{--        <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--            <!-- Left Side Of Navbar -->--}}
{{--            <ul class="navbar-nav me-auto">--}}

{{--            </ul>--}}

{{--            <!-- Right Side Of Navbar -->--}}
{{--            <ul class="navbar-nav ms-auto">--}}
{{--                <!-- Authentication Links -->--}}
{{--                @guest--}}
{{--                    @if (Route::has('login'))--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
{{--                        </li>--}}
{{--                    @endif--}}

{{--                    @if (Route::has('register'))--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                @else--}}
{{--                    <li class="nav-item dropdown">--}}
{{--                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                            {{ Auth::user()->name }}--}}
{{--                        </a>--}}

{{--                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">--}}
{{--                            <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                               onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                {{ __('Logout') }}--}}
{{--                            </a>--}}

{{--                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                                @csrf--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                @endguest--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}
