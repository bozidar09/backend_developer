@extends('admin.layout.master')

@section('title', 'Dodaj kopije')

@section('main') 

    <h1>Dodaj nove kopije</h1>
    <hr>
    <form class="row g-3 mt-3" action="{{ route('copies.store') }}" method="POST">
        @csrf
        <div class="row mt-3">
            <div class="col-1">
                <label for="movie_id" class="mt-1">Film</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="movie_id" name="movie_id">
                    <option selected>Odaberi</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}">{{ $movie->title . ' (' . $movie->year . ')' }}</option>
                        @endforeach
                </select>
                @error('movie_id')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @foreach($formats as $format)
            <div class="row mt-3">
                <div class="col-1">
                    <label for="{{ strtolower($format->type) }}" class="mt-1">{{ $format->type }} količina</label>
                </div>
                <div class="col-6">
                    <input type="number" step="1" class="form-control" id="{{ strtolower($format->type) }}" name="{{ strtolower($format->type) }}" value="{{ old(strtolower($format->type)) }}">
                    @error(strtolower($format->type))
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
        <hr>
        <div class="col-auto">
            <a href="/copies" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>

@endsection