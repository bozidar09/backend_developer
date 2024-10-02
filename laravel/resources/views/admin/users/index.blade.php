@extends('admin.layout.master')

@section('title', 'Korisnici')

@section('main') 

    <div class="title flex-between">
        <h1>Članovi</h1>
        <div class="action-buttons">
            <a href="{{ route('users.create')  }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
        </div>
    </div>
 
    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Članski broj</th>
                <th>Ime i prezime</th>
                <th>Email</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->member_id }}</td>
                    <td><a href="{{ route('users.show',$user->id) }}">{{ $user->fullName() }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit',$user->id) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="{{ route('users.destroy',$user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}


@endsection