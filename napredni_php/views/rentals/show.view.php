<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Posudba</h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row mt-3">
            <div class="col-1">
                <label for="id" class="mt-1">Id posudbe</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="<?= $rental['id'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="member" class="mt-1">Član</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="member" name="member" value="<?= $rental['ime'] . ' ' . $rental['prezime'] . ' (' . $rental['clanski_broj'] . ')' ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="movie" class="mt-1">Film</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="movie" name="movie" value="<?= $rental['naslov'] . ' (' . $rental['godina'] . ')  - ' . $rental['medij'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="rental_return" class="mt-1">Posudba - povrat</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="rental_return" name="rental_return" value="<?= $rental['datum_posudbe'] ?> - <?= $rental['datum_povrata'] ?? '' ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="price" class="mt-1">Cijena</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="price" name="price" value="<?= $rental['cijena'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="late_days" class="mt-1">Dani kašnjenja</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="late_days" name="late_days" value="<?= $rental['dani_kasnjenja'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="late_fee" class="mt-1">Zakasnina</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="late_fee" name="late_fee" value="<?= $rental['zakasnina'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="late_total" class="mt-1">Zakasnina ukupno</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="late_total" name="late_total" value="<?= $rental['zakasnina_ukupno'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="price_total" class="mt-1">Ukupno dugovanje</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="price_total" name="price_total" value="<?= $rental['dugovanje'] ?>" disabled>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-2">
        <a href="/rentals" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
        <a href="/rentals/edit?id=<?= $rental['id'] ?>&movie=<?= $rental['film_id'] ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
        <form id="delete-form" class="hidden d-inline" method="POST" action="/rentals/destroy">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $rental['id'] ?>">
            <input type="hidden" name="id" value="<?= $rental['kopija_id'] ?>">
            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</main>

<?php include_once basePath('views/partials/footer.php') ?>