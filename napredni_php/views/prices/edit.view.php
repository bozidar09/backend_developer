<?php include_once basePath('views/partials/header.php'); ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Uredi tip filma</h1>
    <hr>
    <form class="row g-3 mt-3" action="/prices" method="POST">
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="<?= $price['id'] ?>">
        <div class="row mt-3">
            <div class="col-1">
                <label for="movie_type" class="mt-1">Tip filma</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="movie_type" name="movie_type" value="<?= $price['tip_filma'] ?>" required>
                <span class="text-danger small"><?= $errors['tip_filma'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="price" class="mt-1">Cijena</label>
            </div>
            <div class="col-6">
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $price['cijena'] ?>" required>
                <span class="text-danger small"><?= $errors['cijena'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="late_fee" class="mt-1">Zakasnina</label>
            </div>
            <div class="col-6">
                <input type="number" step="0.01" class="form-control" id="late_fee" name="late_fee" value="<?= $price['zakasnina_po_danu'] ?>" required>
                <span class="text-danger small"><?= $errors['zakasnina_po_danu'] ?? '' ?></span>
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php'); ?>