@extends('admin.layout.master')

@section('title', 'Prijava')

@section('main') 

    <div class="container py-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <h1>Prijava</h1>
            <hr>
            <div class="container-fluid">
                <form class="row g-3 mt-3" action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-1">
                            <label for="email" class="mt-1">Email</label>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-1">
                            <label for="password" class="mt-1">Lozinka</label>
                        </div>
                        <div class="col-6">
                            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="col-auto">
                        <a href="/" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
                        <button class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ulogiraj me">Ulogiraj se</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection