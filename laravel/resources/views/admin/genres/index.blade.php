@extends('admin.layout.master')
 
@section('title', 'Žanrovi')

@section('main')
    
    <div class="title flex-between">
        <h1>Žanrovi</h1>
        <div class="action-buttons">
            <a href="{{ route('genres.create') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
        </div>
    </div>

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Tip</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($genres as $genre)
                <tr>
                    <td>{{$genre->id}}</td>
                    <td><a href="{{ route('genres.show', $genre->id) }}">{{ $genre->name }}</a></td>
                    <td>
                        <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('genres.destroy', $genre->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $genres->links() }}

@endsection