@extends('frontend.layout.master')

@section('title', 'Videoteka')

@section('home')

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid">
            <h1 class="display-5 fw-bold">Najpopularniji filmovi</h1>
            <ul class="list-group my-5">
                @foreach($popularMovies as $movie)
                    <li class="list-group-item bg-body-tertiary">
                        {{ $movie->movie_title }} ({{ $movie->movie_year }}) - {{ $movie->genre }}
                        <span class="badge text-bg-primary float-end"> {{ $movie->type }} </span>
                    </li>
                @endforeach
            </ul>
            <div class="action-buttons">
                <a href="/movies" class="btn btn-outline-secondary">Vidi sve!</a>
            </div>
        </div>
    </div>             

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid">
            <h1 class="display-5 fw-bold">Žanrovi</h1>

            <div class="d-grid gap-3 mt-5" style="grid-template-columns: 1fr 1fr 1fr;">
                @php $counter = 0; @endphp
                @foreach($moviesByGenre as $key => $moviesInGenre)
                    @php
                        $isEven = $counter % 2 == 0;
                        $counter++;
                    @endphp
                    <div class="h-100 p-5 {{ $isEven ? 'text-bg-dark' : 'bg-body-tertiary border' }} rounded-3">
                        <h2>{{ $key }}</h2>
                        <ul class="list-group my-4">
                            @foreach($moviesInGenre as $movie)
                                <li class="list-group-item {{ $isEven ? 'text-bg-dark' : 'bg-body-tertiary' }}">
                                    {{ $movie->movie_title }} ({{ $movie->movie_year }})
                                    <span class="badge text-bg-primary float-end">{{ $movie->type }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="action-buttons">
                            <a href="{{ route('genres.show', $movie->genre_id) }}" type="submit" class="btn {{ $isEven ? 'btn-outline-light' : 'btn-outline-secondary' }}">Vidi više!</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection