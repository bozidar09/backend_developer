@extends('admin.layout.master')

@section('title', $user->first_name . ' ' . $user->last_name)

@section('main') 

    <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row mt-3">  
            <div class="col-1">
                <label for="id" class="mt-1">Id člana</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="{{ $user->id }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="member_id" class="mt-1">Članski broj</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="member_id" name="member_id" value="{{ $user->member_id }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="first_name" class="mt-1">Ime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="last_name" class="mt-1">Prezime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="email" class="mt-1">Email</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-2">
        <a href="/users" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('users.destroy', $user->id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
        </form>
    </div>
    <hr>
    <h2>{{ $user->ime }} {{ $user->prezime }} Trenutne posudbe</h2>
    <hr>
    <div class="overflow-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Datum</th>
                    <th>Naslovi</th>
                    <th>Ukupna cijena</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->id}}</td>
                        <td><a href="/rentals/show?id={{ $rental->id }}">{{ $rental->rental_date }}</a></td>
                        <td>
                            @foreach($rental->copies as $copy)
                                {{ $copy->movie->title . ' (' . $copy->movie->year . ') - ' . $copy->format->type}}<br>
                            @endforeach
                        </td>
                        <td>{{ $rental->price_total}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection