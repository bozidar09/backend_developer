@extends('admin.layout.master')

@section('title', 'Posudba')

@section('main') 

    <h1>Posudba</h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row mt-3">
            <div class="col-1">
                <label for="id" class="mt-1">Id posudbe</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="{{ $rental->id }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="member" class="mt-1">Član</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="member" name="member" value="{{ $rental->user->fullNameId() }}" disabled>
            </div>
        </div>
        @foreach($rental->copies as $copy)
            <hr>
            <div class="row mt-3">
                <div class="col-1">
                    <label for="movie" class="mt-1">Film</label>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="movie" name="movie" value="{{ $copy->movie->title . ' (' . $copy->movie->year . ')  - ' . $copy->format->type }}" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1">
                    <label for="rental_return" class="mt-1">Posudba - povrat</label>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="rental_return" name="rental_return" value="{{ $rental->rental_date }} - {{ $copy->pivot->return_date ?? '' }}" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1">
                    <label for="price" class="mt-1">Cijena</label>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="price" name="price" value="{{ $copy->movie->price->price }}" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1">
                    <label for="late_days" class="mt-1">Dani kašnjenja</label>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="late_days" name="late_days" value="{{ $copy->late_days }}" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1">
                    <label for="late_fee" class="mt-1">Zakasnina</label>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="late_fee" name="late_fee" value="{{ $copy->movie->price->late_fee }}" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1">
                    <label for="late_total" class="mt-1">Zakasnina ukupno</label>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="late_total" name="late_total" value="{{ $copy->late_total }}" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1">
                    <label for="price_total" class="mt-1">Dugovanje za film</label>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="price_total" name="price_total" value="{{ $copy->price_total }}" disabled>
                </div>
            </div>
        @endforeach
    </form>
    <hr>
    <div class="row mt-3">
        <div class="col-1">
            <label for="price_total" class="mt-1">Ukupno dugovanje</label>
        </div>
        <div class="col-6">
            <input type="text" class="form-control" id="price_total" name="price_total" value="{{ $rental->price_total }}" disabled>
        </div>
    </div>
    <hr>
    <div class="col-2">
        <a href="{{url()->previous()}}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
        <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('rentals.destroy', $rental->id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
        </form>
    </div>

@endsection