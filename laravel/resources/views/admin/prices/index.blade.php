@extends('admin.layout.master')

@section('title', 'Cjenik')

@section('main')

    <div class="title flex-between">    
        <h1>Cjenik</h1>
        <div class="action-buttons">
            <a href="{{ route('prices.create') }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
        </div>
    </div>

    <hr>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Tip cijene</th>
                <th>Cijena</th>
                <th>Zakasnina po danu</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prices as $price)
                <tr>
                    <td>{{$price->id}}</td>
                    <td><a href="{{ route('prices.show', $price->id) }}">{{ $price->type }}</a></td>
                    <td>{{ $price->price }}</td>
                    <td>{{ $price->late_fee }}</td>
                    <td>
                        <a href="{{ route('prices.edit', $price->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('prices.destroy', $price->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $prices->links() }}


@endsection