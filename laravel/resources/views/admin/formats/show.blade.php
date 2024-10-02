@extends('admin.layout.master')

@section('title', $format->type)

@section('main') 

    <h1>{{ $format->type }}</h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row mt-3">
            <div class="col-1">
                <label for="id" class="mt-1">Id medija</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="{{ $format->id }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="type" class="mt-1">Naziv medija</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="type" name="type" value="{{ $format->type }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="coefficient" class="mt-1">Koeficijent</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="coefficient" name="coefficient" value="{{ $format->coefficient }}" disabled>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-2">
        <a href="/formats" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
        <a href="{{ route('formats.edit', $format->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('formats.destroy', $format->id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
        </form>    
    </div>
    <hr>
    <h2>{{ $format->type }} filmovi</h2>
    <hr>
    <div class="overflow-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Naslov</th>
                    <th>Godina</th>
                    <th>Žanr</th>
                    <th>Tip</th>
                    <th>Količina</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movies as $movie)
                    <tr>
                        <td>{{ $movie->id }}</td>
                        <td><a href="{{ route('movies.show', $movie->id) }}">{{ $movie->title }}</a></td>
                        <td>{{ $movie->year }}</td>
                        <td>{{ $movie->genre }}</td>
                        <td>{{ $movie->price }}</td>
                        <td>{{ $movie->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection