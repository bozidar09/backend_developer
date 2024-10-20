@extends('admin.layout.master')

@section('title', 'Količine')

@section('main') 

    <div class="title flex-between">    
        <h1>Količine</h1>
        <div class="action-buttons">
            <a href="{{ route('copies.create') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
        </div>
    </div>

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Barkod</th>
                <th>Naslov</th>
                <th>Medij</th>
                <th>Količina</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($quantities as $quantity)
                <tr>
                    <td>{{ $quantity->movie_id }}</td>
                    <td><a href="{{ route('copies.show', $quantity->barcode) }}">{{ $quantity->barcode }}</a></td>
                    <td>{{ $quantity->title }}</td>
                    <td>{{ $quantity->type }}</td>
                    <td>{{ $quantity->quantity }}</td>
                    <td>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('copies.destroy.all', $quantity->barcode) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $quantities->links() }}


@endsection