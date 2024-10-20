@extends('admin.layout.master')

@section('title', 'Uredi žanr')

@section('main')

    <h1>Uredi žanr</h1>
    <hr>
    <form class="row g-3 mt-3" action="{{ route('genres.update', $genre->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-1">
            <label for="name" class="mt-1">Naziv žanra</label>
        </div>
        <div class="col-6">
            <input type="text" class="form-control" id="name" name="name" value="{{ $genre->name }}" required>
            @error('name')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
        <hr>
        <div class="col-6">
            <a href="{{ url()->previous() }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>

@endsection