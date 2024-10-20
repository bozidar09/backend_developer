<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1><?= $rental['clanski_broj'] . ' posuđuje ' . $rental['naslov'] . ' - ' . $rental['medij'] ?></h1>
    <hr>
    <form class="row g-3 mt-3" action="/rentals" method="POST">
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="<?= $rental['id'] ?>">
        <input type="hidden" name="copy_id" value="<?= $rental['kopija_id'] ?>">
    <form class="row g-3 mt-3">
        <div class="row mt-3">
            <div class="col-1">
                <label for="rental" class="mt-1">Datum posudbe</label>
            </div>
            <div class="col-6">
                <input type="date" id="rental" name="rental" value="<?= $rental['datum_posudbe'] ?>">
                <span class="text-danger small"><?= $errors['datum_posudbe'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="return" class="mt-1">Datum povrata</label>
            </div>
            <div class="col-6">
            <input type="date" id="return" name="return" value="<?= $rental['datum_povrata'] ?? '-' ?>">
            <span class="text-danger small"><?= $errors['datum_povrata'] ?? '' ?></span>
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php') ?>