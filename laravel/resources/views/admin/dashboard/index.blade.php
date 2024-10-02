@extends('admin.layout.master')

@section('title', 'Nadzorna ploča')

@section('main')  
    
    <h1>Nova posudba</h1>
    <hr>
    <form class="row g-3 mt-3" action="{{ route('rentals.store') }}" method="POST">
        @csrf
        <div class="row mt-3">
            <div class="col-1">
                <label for="user" class="mt-1">Član</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="user" name="user">
                    <option selected>Odaberi</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->fullNameId() }}</option>
                        @endforeach
                </select>
                @error('user')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="copy" class="mt-1">Kopija filma</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="copy" name="copy">
                    <option selected>Odaberi</option>
                        @foreach($copies as $copy)
                            <option value="{{ $copy->barcode }}">{{ $copy->title . ' (' . $copy->year . ') - ' . $copy->type . ' (' . $copy->amount . ')' }}</option>
                        @endforeach
                </select>
                @error('copy')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
    <hr>

    <div class="title flex-between">    
        <h1>Aktivne posudbe</h1>
    </div>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Datum posudbe</th>
                <th>Član</th>
                <th>Naslov</th>
                <th>Ukupna cijena</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
                @foreach($rental->copies as $copy)
                    <tr>
                        <td>{{ $rental->id }}</td>
                        <td><a href="{{ route('rentals.show', $rental->id) }}">{{ $rental->rental_date}}</a></td>
                        <td>{{ $rental->user->first_name . ' ' . $rental->user->last_name . ' (' . $rental->user->member_id . ')' }}</td>
                        <td>
                            {{ $copy->movie->title . ' (' . $copy->movie->year . ') - ' . $copy->format->type }}<br>
                        </td>
                        <td>{{ $rental->price_total }}</td>
                        <td>
                            <form action="{{ route('dashboard.return', [$rental->id, $copy->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Vrati"><i class="bi bi-arrow-counterclockwise"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    {{ $rentals->links() }}

@endsection
