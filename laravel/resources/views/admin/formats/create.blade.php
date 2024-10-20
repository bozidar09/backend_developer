@extends('admin.layout.master')

@section('title', 'Dodaj medij')

@section('main') 

    <h1>Dodaj novi medij</h1>
    <hr>
    <form class="row g-3 mt-3" action="{{ route('formats.store') }}" method="POST">
        @csrf
        <div class="row mt-3">
            <div class="col-1">
                <label for="type" class="mt-1">Naziv medija</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}" required>
                @error('type')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="coefficient" class="mt-1">Koeficijent</label>
            </div>
            <div class="col-6">
                <input type="number" step="0.01" class="form-control" id="coefficient" name="coefficient" value="{{ old('coefficient') }}" required>
                @error('coefficient')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="/media" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>

@endsection