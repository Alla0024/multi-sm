@isset($word)
    <div class="sidebar-customer" :class="{'sidebar_hide':Alpine.store('page').sidebar_hide}">

    <div class="logo">
        <img width="40" :class="{'hide_opacity': Alpine.store('page').sidebar_hide}" :src="$store.page.theme == 'dark' ? '/images/common/logo_new_light.png' : '/images/common/logo_new_light.png'" alt="">
    </div>

    <div class="items-link">
        <a href="{{asset('/aikqweu')}}" class="item {{ Request::is('aikqweu/dashboard*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-houses-fill fs-20"></i></div>
            <div class="name">Головна</div>
        </a>

{{--        <div class="item-list" x-data="{open_list: {{ Request::is('aikqweu/example*') ? 'true' : 'false' }}}">--}}
{{--            <div class="item {{ Request::is('aikqweu/example*') ? 'active' : '' }}" @click="open_list = !open_list">--}}
{{--                <div class="icon"><i class="bi bi-gear-fill fs-20"></i></div>--}}
{{--                <div class="name">Example</div>--}}
{{--                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>--}}
{{--            </div>--}}
{{--            <div class="list" :class="{'list-open': open_list}">--}}
{{--                <a class="item {{ Request::is('aikqweu/example') ? 'active' : '' }}" href="{{asset('/aikqweu/example')}}">Form</a>--}}
{{--                <a class="item {{ Request::is('aikqweu/example/edit*') ? 'active' : '' }}" href="{{asset('/aikqweu/example/edit')}}">Inputs</a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <a href="{{ route('languages.index') }}" class="item {{ Request::is('aikqweu/languages*') ? 'active' : '' }}">--}}
{{--            <div class="icon"><i class="bi bi-houses-fill fs-20"></i></div>--}}
{{--            <div class="name">Languages</div>--}}
{{--        </a>--}}
{{--        <a href="{{ route('stores.index') }}" class="item {{ Request::is('aikqweu/stores*') ? 'active' : '' }}">--}}
{{--            <div class="icon"><i class="bi bi-houses-fill fs-20"></i></div>--}}
{{--            <div class="name">Stores</div>--}}
{{--        </a>--}}


        <a href="{{ route('manufacturers.index') }}" class="item {{ Request::is('aikqweu/manufacturers*') ? 'active' : '' }}">
            <div class="icon"><i class="bi bi-houses-fill fs-20"></i></div>
            <div class="name">{{$word['menu_manufacturers']}}</div>
        </a>

        <div class="item-list" x-data="{open_list: {{ Request::is(['aikqweu/news*', 'aikqweu/information*', 'aikqweu/articleAuthors']) ? 'true' : 'false' }}}">
            <div class="item {{ Request::is(['aikqweu/news*', 'aikqweu/information*']) ? 'active' : '' }}" @click="open_list = !open_list">
                <div class="icon"><i class="bi bi-gear-fill fs-20"></i></div>
                <div class="name">{{$word['menu_new']}}</div>
                <div class="arrow" :class="{'rotate': open_list}"><i class="bi bi-caret-down-fill fs-20"></i></div>
            </div>
            <div class="list" :class="{'list-open': open_list}">
                <a class="item {{ Request::is('aikqweu/information') ? 'active' : '' }}" href="{{ route('information.index') }}">{{$word['menu_informations']}}</a>
                <a class="item {{ Request::is('aikqweu/news') ? 'active' : '' }}" href="{{ route('news.index') }}">{{$word['menu_news']}}</a>
                <a class="item {{ Request::is('aikqweu/articleAuthors') ? 'active' : '' }}" href="{{ route('articleAuthors.index') }}">{{$word['menu_article_authors']}}</a>
                <a class="item {{ Request::is('aikqweu/newsCategories*') ? 'active' : '' }}" href="{{ route('newsCategories.index') }}">News category</a>
            </div>
        </div>

{{--        <a href="{{ route('manufacturerDescriptions.index') }}" class="item {{ Request::is('aikqweu/manufacturerDescriptions*') ? 'active' : '' }}">--}}
{{--            <div class="icon"><i class="bi bi-houses-fill fs-20"></i></div>--}}
{{--            <div class="name">Manufacturer Descriptions</div>--}}
{{--        </a>--}}

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
