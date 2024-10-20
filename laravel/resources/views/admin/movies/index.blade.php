@extends('admin.layout.master')

@section('title', 'Filmovi')

@section('main')

    <div class="title flex-between">    
        <h1>Filmovi</h1>
        <div class="action-buttons">
            <a href="{{ route('movies.create' )}}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
        </div>
    </div> 

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Naslov</th>
                <th>Godina</th>
                <th>Žanr</th>
                <th>Medij</th>
                <th>Tip</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
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
                    <td>{{ $movie->price->type}}</td>
                    <td>
                        <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('movies.destroy', $movie->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $movies->links() }}

@endsection