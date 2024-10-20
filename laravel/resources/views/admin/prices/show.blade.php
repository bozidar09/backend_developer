@extends('admin.layout.master')

@section('title', $price->type)

@section('main')

    <h1>{{ $price->type }}</h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row">
            <div class="col-1">
                <label for="id" class="mt-1">Id</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="{{ $price->id }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="type" class="mt-1">Tip cijene</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="type" name="type" value="{{ $price->type }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="price" class="mt-1">Cijena</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="price" name="price" value="{{ $price->price }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="late_fee" class="mt-1">Zakasnina</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="late_fee" name="late_fee" value="{{ $price->late_fee }}" disabled>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-2">
        <a href="/prices" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
        <a href="{{ route('prices.edit', $price->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('prices.destroy', $price->id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
        </form>
    </div>
    <hr>
    <h2>{{ $price->type }} filmovi</h2>
    <hr>
    <div class="overflow-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Naslov</th>
                    <th>Godina</th>
                    <th>Žanr</th>
                    <th>Medij</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($price->movies as $movie)
                    <tr>
                        <td>{{ $movie->id }}</td>
                        <td><a href="{{ route('movies.show', $movie->id) }}">{{ $movie->title }}</a></td>
                        <td>{{ $movie->year }}</td>
                        <td>{{ $movie->genre->name }}</td>
                        <td>
                            @php $iconArray = []; @endphp
                            @foreach($movie->copies as $copy)
                                @php 
                                    $formatIcon = match ($copy->format->type) {
                                        'DVD' => 'disc-fill text-warning',
                                        'Blu-ray' => 'disc text-primary',
                                        'VHS' => 'cassette-fill text-success',
                                        default => 'disc-fill text-secondary'
                                    }; 
                                @endphp
                                @if(!in_array($formatIcon, $iconArray))
                                    @php $iconArray[] = $formatIcon; @endphp
                                    <span class="badge text-bg-light float-start"><i class="bi bi-{{ $formatIcon }} me-1"></i>{{ $copy->format->type }}</span>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection