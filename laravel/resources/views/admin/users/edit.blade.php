@extends('admin.layout.master')

@section('title', 'Uredi korisnika')

@section('main') 

    <h1>Uredi člana</h1>
    <hr>
    <form class="row g-3 mt-3" action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mt-3">
            <div class="col-1">
                <label for="member_id" class="mt-1">Članski broj</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="member_id" name="member_id" value="{{ $user->member_id }}" required>
                @error('member_id')
                    <span class="text-danger small">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="first_name" class="mt-1">Ime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" required>
                @error('first_name')
                    <span class="text-danger small">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="last_name" class="mt-1">Prezime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" required>
                @error('last_name')
                    <span class="text-danger small">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="email" class="mt-1">Email</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                @error('email')
                    <span class="text-danger small">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="password" class="mt-1">Nova lozinka</label>
            </div>
            <div class="col-6">
                <input type="password" class="form-control" id="password" name="password" value="" required>
                @error('password')
                    <span class="text-danger small">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="password_confirmation" class="mt-1">Potvrda lozinke</label>
            </div>
            <div class="col-6">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" required>
                @error('password_confirmation')
                    <span class="text-danger small">{{$message}}</span>
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