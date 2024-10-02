@extends('admin.layout.master')

@section('title', 'Nova cijena')

@section('main')

    <h1>Nova cijena</h1>
    <hr>
    <form class="row g-3 mt-3" action="{{ route('prices.store') }}" method="POST">
        {{-- cross site request forgery --}}
        @csrf 
        <div class="row mt-3">
            <div class="col-1">
                <label for="type" class="mt-1">Tip cijene</label>
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
                <label for="price" class="mt-1">Cijena</label>
            </div>
            <div class="col-6">
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                @error('price')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="late_fee" class="mt-1">Zakasnina</label>
            </div>
            <div class="col-6">
                <input type="number" step="0.01" class="form-control" id="late_fee" name="late_fee" value="{{ old('late_fee') }}" required>
                @error('late_fee')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="/prices" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>

@endsection