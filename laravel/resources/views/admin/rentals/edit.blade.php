@extends('admin.layout.master')

@section('title', 'Uredi posudbu')

@section('main') 

    <h1>{{ $rental->user->member_id . ' posudba'}}</h1>
    <form class="row g-3 mt-3" action="{{ route('rentals.update', $rental->id) }}" method="POST">
        @csrf
        @method('PUT')
        <hr>
        <div class="row mt-3">
            <div class="col-1">
                <label for="rental_date" class="mt-1">Datum posudbe</label>
            </div>
            <div class="col-6">
                <input type="datetime-local" id="rental_date" name="rental_date" value="{{ $rental->rental_date }}">
                @error('rental_date')
                    <span class="text-danger small">{{$message}}</span>
                @enderror
            </div>
        </div>
        @foreach ($rental->copies as $copy)
            <hr>
            <h2>{{ $copy->movie->title . ' - ' . $copy->format->type }}</h2>
            <div class="row mt-3">
                <div class="col-1">
                    <label for="return_date" class="mt-1">Datum povrata</label>
                </div>
                <div class="col-6">
                <input type="datetime-local" id="return_date" name="return_date_{{ $copy->id }}" value="{{ $copy->pivot->return_date ?? '-' }}">
                @error("return_date_{{ $copy->id }}")
                    <span class="text-danger small">{{$message}}</span>
                @enderror
                </div>
            </div>
        @endforeach
        <hr>
        <div class="col-auto">
            <a href="{{ url()->previous() }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>

@endsection