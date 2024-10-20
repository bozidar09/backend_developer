@extends('admin.layout.master')

@section('title', 'Mediji')

@section('main') 

    <div class="title flex-between">    
        <h1>Mediji</h1>
        <div class="action-buttons">
            <a href="{{ route('formats.create') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
        </div>
    </div>

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Tip</th>
                <th>Koeficijent</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($formats as $format)
                <tr>
                    <td>{{ $format->id }}</td>
                    <td><a href="{{ route('formats.show', $format->id) }}">{{ $format->type }}</a></td>
                    <td>{{ $format->coefficient }}</td>
                    <td>
                        <a href="{{ route('formats.edit', $format->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('formats.destroy', $format->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $formats->links() }}

@endsection