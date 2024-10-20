@extends('admin.layout.master')

@section('title', 'Nova posudba')

@section('main') 

    <h1>Nova posudba</h1>
    <hr>
    <form class="row g-3 mt-3" action="{{ route('rentals.store') }}" method="POST">
        @csrf
        <div class="row mt-3">
            <div class="col-1">
                <label for="user" class="mt-1">Član</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="user" name="user">
                    <option selected>Odaberi</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ Auth::user()->is($user) ? 'selected' : '' }}>{{ $user->first_name . ' ' . $user->last_name . ' (' . $user->member_id . ')' }}</option>
                        @endforeach
                    </select>
                @error('user')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="copy" class="mt-1">Kopija filma</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="copy" name="copy">
                    <option selected>Odaberi</option>
                        @foreach($copies as $copy)
                            <option value="{{ $copy->barcode }}">{{ $copy->title . ' (' . $copy->year . ') - ' . $copy->type . ' (' . $copy->amount . ')' }}</option>
                        @endforeach
                </select>
                @error('copy')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="/rentals" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>

@endsection