@foreach (session()->only(['success', 'danger']) as $key => $message)
    <div class="alert alert-{{$key}} alert-dismissible fade show" role="alert">
        {{$message}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endforeach