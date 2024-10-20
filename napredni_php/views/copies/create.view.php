<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Dodaj nove kopije</h1>
    <hr>
    <form class="row g-3 mt-3" action="/copies" method="POST">
        <div class="row mt-3">
            <div class="col-1">
                <label for="movie" class="mt-1">Film</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="movie" name="movie">
                    <option selected>Odaberi</option>
                        <?php foreach ($movies as $movie): ?>
                            <option value="<?= $movie['id'] . '-' . $movie['naslov'] ?>"><?= $movie['naslov'] . ' (' . $movie['godina'] . ')' ?></option>
                        <?php endforeach ?>
                </select>
                <span class="text-danger small"><?= $errors['film_id'] ?? '' ?></span>
                <span class="text-danger small"><?= $errors['naslov'] ?? '' ?></span>
            </div>
        </div>
        <?php foreach ($mediaAll as $media): ?>
            <div class="row mt-3">
                <div class="col-1">
                    <label for="<?= strtolower($media['tip']) ?>" class="mt-1"><?= $media['tip'] ?> količina</label>
                </div>
                <div class="col-6">
                    <input type="number" step="1" class="form-control" id="<?= strtolower($media['tip']) ?>" name="<?= strtolower($media['tip']) ?>" value="<?= $old[strtolower($media['tip'])] ?? '' ?>">
                    <span class="text-danger small"><?= $errors[strtolower($media['tip'])] ?? '' ?></span>
                </div>
            </div>
        <?php endforeach ?>
        <hr>
        <div class="col-auto">
            <a href="/copies" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php') ?>  