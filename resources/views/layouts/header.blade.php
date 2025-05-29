<div class="header hide" x-data>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

            <a class="navbar-brand" href="#">multi-sm</a>
            <div class="navbar-brand">Name</div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Головна</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="chang-color" @click="$store.page.changeColor()">
            c
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Вийти</button>
        </form>
    </nav>
</div>




<div class="header">
    <div class="wrapper-head">

        <div class="catalog-butt" @click="$store.page.sidebar_hide = !$store.page.sidebar_hide">
            <svg width="24px" height="24px" viewBox="0 0 24 24" id="align-left" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line"><path id="primary" d="M3,12H17M3,6H21M3,18H21" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>
        </div>

        <div class="search">
            <input type="text"  placeholder="Пошук...">
        </div>

        <div class="custom-control">
            <div class="change-team" @click="$store.page.changeTheme()">
                <svg  width="24" height="24" viewBox="-2 -1.5 24 24" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin" class="jam jam-sun-f"><path d='M10 15.565a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-15a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1zm0 16a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1zm-9-7h2a1 1 0 1 1 0 2H1a1 1 0 0 1 0-2zm16 0h2a1 1 0 0 1 0 2h-2a1 1 0 0 1 0-2zm.071-6.071a1 1 0 0 1 0 1.414l-1.414 1.414a1 1 0 1 1-1.414-1.414l1.414-1.414a1 1 0 0 1 1.414 0zM5.757 14.808a1 1 0 0 1 0 1.414l-1.414 1.414a1 1 0 1 1-1.414-1.414l1.414-1.414a1 1 0 0 1 1.414 0zM4.343 3.494l1.414 1.414a1 1 0 0 1-1.414 1.414L2.93 4.908a1 1 0 0 1 1.414-1.414zm11.314 11.314l1.414 1.414a1 1 0 0 1-1.414 1.414l-1.414-1.414a1 1 0 1 1 1.414-1.414z' /></svg>
            </div>
        </div>
        @guest

        @else
        <div class="user">
            <div class="img">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="49.1667" fill="#E4E4E4" stroke="#E4E4E4" stroke-width="1.66667"></circle>
                    <path d="M34.168 65.6552C35.3821 62.8262 36.5963 59.9973 37.8105 57.1684C38.0222 56.6484 38.4118 56.2249 38.9068 55.9766C40.6219 55.0798 42.3283 54.1769 44.0257 53.2681C44.1565 53.1713 44.3161 53.1239 44.4773 53.1337C44.6385 53.1436 44.7913 53.2102 44.9099 53.3222C46.3822 54.4313 48.1639 55.0294 49.9935 55.0286C51.7665 55.0542 53.5012 54.5007 54.9445 53.4486C55.1143 53.289 55.3305 53.1903 55.5603 53.1675C55.79 53.1447 56.0208 53.199 56.2176 53.3222C57.8443 54.2251 59.4976 55.1279 61.142 55.9495C61.5971 56.179 61.9575 56.5662 62.1588 57.042C63.3081 59.7505 64.4751 62.3598 65.6245 65.0322C65.7514 65.2695 65.8245 65.5329 65.8384 65.8029C65.8523 66.0729 65.8066 66.3426 65.7048 66.5922C65.603 66.8418 65.4475 67.0648 65.25 67.2449C65.0525 67.4249 64.8179 67.5573 64.5635 67.6324C64.3255 67.7044 64.0779 67.7379 63.8297 67.7317H36.166C35.7102 67.7729 35.2553 67.6422 34.8872 67.3645C34.5192 67.0867 34.2633 66.6811 34.168 66.224V65.6552Z" stroke="#0073BE" stroke-width="1.66667"></path>
                    <path d="M57.3877 40.7528C57.3972 43.0713 56.4664 45.3013 54.7944 46.9659C54.1765 47.5955 53.4322 48.0969 52.6068 48.4396C51.7814 48.7823 50.8924 48.959 49.9939 48.959C49.0954 48.959 48.2064 48.7823 47.381 48.4396C46.5556 48.0969 45.8113 47.5955 45.1934 46.9659C44.3397 46.1088 43.6722 45.0957 43.23 43.986C42.7878 42.8764 42.5799 41.6926 42.6185 40.5043C42.5847 39.0427 42.8374 37.5882 43.3634 36.2173C43.7159 35.2567 44.3281 34.4046 45.1366 33.7491C45.9451 33.0937 46.9204 32.6588 47.9615 32.4894C49.7201 32.1041 51.5565 32.2181 53.2494 32.8178C54.0092 33.0975 54.6997 33.5281 55.2764 34.0815C55.853 34.635 56.3028 35.2991 56.5969 36.0309C57.1735 37.5409 57.442 39.1443 57.3877 40.7528Z" stroke="#0073BE" stroke-width="1.66667"></path>
                </svg>
            </div>

            <div class="info">
                <div class="name">
                    {{ Auth::user()->name }}
                </div>
                <div class="description">
                    Frontend developer
                </div>
            </div>
        </div>
            <div class="logout" title="Logout" @click="$store.page.logout">
                <i class="bi bi-arrow-bar-right fs-80" style="display: flex; height: 26px"></i>
            </div>
        @endguest


    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
