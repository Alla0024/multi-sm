
<li class="nav-item">
    <a href="{{ route('languages.index') }}" class="nav-link {{ Request::is('languages*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Languages</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('stores.index') }}" class="nav-link {{ Request::is('stores*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Stores</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('manufacturers.index') }}" class="nav-link {{ Request::is('manufacturers*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Manufacturers</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('manufacturerDescriptions.index') }}" class="nav-link {{ Request::is('manufacturerDescriptions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Manufacturer Descriptions</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('langs.index') }}" class="nav-link {{ Request::is('langs*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Langs</p>
    </a>
</li>
