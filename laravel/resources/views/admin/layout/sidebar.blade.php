<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <span class="fs-4">Videoteka Admin</span>
</a>

<hr>

<ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
        <a href="/" class="nav-link text-white link-primary" aria-current=""><i class="bi bi-house me-2"></i>Home</a>
    </li>
    <li class="nav-item">
        <a href="/dashboard" class="nav-link text-white link-primary {{request()->is('dashboard') ? 'active' : ''}}" aria-current="{{request()->is('members') ? 'page' : 'false'}}"><i class="bi bi-clipboard-pulse me-2"></i>Nadzorna ploča</a>
    </li>
    <li class="nav-item">
        <a href="/rentals" class="nav-link text-white link-primary {{request()->is('rentals') ? 'active' : ''}}" aria-current="{{request()->is('rentals') ? 'page' : 'false'}}"><i class="bi bi-credit-card me-2"></i>Posudbe</a>
    </li>
    <li class="nav-item">
        <a href="/users" class="nav-link text-white link-primary {{request()->is('users') ? 'active' : ''}}" aria-current="{{request()->is('members') ? 'page' : 'false'}}"><i class="bi bi-person-circle me-2"></i>Članovi</a>
    </li>
    <li class="nav-item">
        <a href="/movies" class="nav-link text-white link-primary {{request()->is('movies') ? 'active' : ''}}" aria-current="{{request()->is('movies') ? 'page' : 'false'}}"><i class="bi bi-film me-2"></i>Filmovi</a>
    </li>
    <li class="nav-item">
        <a href="/genres" class="nav-link text-white link-primary {{request()->is('genres') ? 'active' : ''}}" aria-current="{{request()->is('genres') ? 'page' : 'false'}}"><i class="bi bi-camera-reels me-2"></i>Žanrovi</a>
    </li>
    <li class="nav-item">
        <a href="/prices" class="nav-link text-white link-primary {{request()->is('prices') ? 'active' : ''}}" aria-current="{{request()->is('prices') ? 'page' : 'false'}}"><i class="bi bi-currency-euro me-2"></i>Cjenik</a>
    </li>
    <li class="nav-item">
        <a href="/formats" class="nav-link text-white link-primary {{request()->is('formats') ? 'active' : ''}}" aria-current="{{request()->is('media') ? 'page' : 'false'}}"><i class="bi bi-disc me-2"></i>Mediji</a>
    </li>
    <li class="nav-item">
        <a href="/copies" class="nav-link text-white link-primary {{request()->is('copies') ? 'active' : ''}}" aria-current="{{request()->is('copies') ? 'page' : 'false'}}"><i class="bi bi-stack me-2"></i>Količine</a>
    </li>
</ul>