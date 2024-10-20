@extends('admin.layout.master')

@section('title', 'Posudbe')

@section('main') 

    <div class="title flex-between">    
        <h1>Posudbe</h1>
        <div class="action-buttons">
            <a href="{{ route('rentals.create') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
        </div>
    </div>
 
    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Posudba</th>
                <th>Povrat</th>
                <th>Član</th>
                <th>Naslovi - medij</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
                <tr>
                    <td>{{$rental->id}}</td>
                    <td><a href="{{ route('rentals.show', $rental->id) }}">{{ $rental->rental_date }}</a></td>
                    <td>{{ $rental->return_date ?? '-' }}</td>
                    <td>{{ $rental->user->fullNameId() }}</td>
                    <td> 
                        @foreach($rental->copies as $copy)
                            {{ $copy->movie->title . ' (' . $copy->movie->year . ') - ' . $copy->format->type }}<br>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('rentals.destroy', $rental->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $rentals->links() }}

@endsection