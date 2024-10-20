<div class="d-flex gap-2 flex-wrap align-items-center justify-content-center justify-content-lg-start">
    <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><title>Bootstrap</title><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
        <span class="fs-4">Videoteka</span>
    </a>
    
    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 flex-grow-1">
        <li><a href="/" class="nav-link px-2 text-secondary">Home</a></li>
        <li><a href="/dashboard" class="nav-link px-2 text-dark">Nadzorna ploča</a></li>
    </ul>
    <div class="text-end">
        @auth
            <div class="dropdown">
                <a href="#" class="d-flex p-1 align-items-center text-body text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://logosandtypes.com/wp-content/uploads/2023/12/Algebra.png" alt="A" width="32" height="32" class="rounded-circle me-2 border border-secondary">
                    <strong>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</strong> 
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow">
                    <li><a class="dropdown-item" href="{{ route('rentals.create') }}">Nova posudba</a></li>
                    <li><a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">Profil</a></li>
                    <li><a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">Uredi</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form class="ml-2 p-2 d-inline" action="{{ route('logout') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-2">Odjava</a>
                        </form>
                    </li>
                </ul>
            </div>
        @else   
            <a href="{{ route('login.create') }}" type="button" class="btn btn-warning d-block">Prijava</a>
            <a href="{{ route('register.create') }}" type="button" class="btn btn-primary d-block">Registracija</a>
        @endauth
    </div>
</div>