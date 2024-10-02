@extends('admin.layout.master')

@section('title', 'Uredi kopiju')

@section('main') 

    <h1>Uredi kopiju #{{ $copy->id }}</h1>
    <hr>
    <form class="row g-3 mt-3" action="{{ route('copies.update', $copy->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mt-3">
            <div class="col-1">
                <label for="barcode" class="mt-1">Barkod</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="barcode" name="barcode" value="{{ $copy->barcode }}" required>
                @error('barcode')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="available" class="mt-1">Dostupan</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="available" name="available">
                        <option value="0" {{ $copy->available === 0 ? 'selected' : '' }}>0</option>
                        <option value="1" {{ $copy->available === 1 ? 'selected' : '' }}>1</option>
                </select>
                @error('available')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="{{ url()->previous() }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>

@endsection