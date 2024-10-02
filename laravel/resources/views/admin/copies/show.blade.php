@extends('admin.layout.master')

@section('title', $copy->barcode)

@section('main') 

    <div class="title flex-between">    
        <h1>Kopije</h1>
    </div>

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Naslov</th>
                <th>Barkod</th>
                <th>Medij</th>
                <th>Dostupan</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($copies as $copy)
                <tr>
                    <td>{{ $copy->id }}</td>
                    <td>{{ $copy->movie->title . ' (' . $copy->movie->year . ')'}}</a></td>
                    <td>{{ $copy->barcode }}</td>
                    <td>{{ $copy->format->type }}</td>
                    <td>{{ $copy->available }}</td>
                    <td>
                        <a href="{{ route('copies.edit', $copy->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('copies.destroy', $copy->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-2">
        <a href="/copies" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
    </div>

@endsection