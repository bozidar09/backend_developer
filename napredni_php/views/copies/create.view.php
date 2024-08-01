<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Dodaj nove kopije</h1>
    <hr>
    <form class="row g-3 mt-3" action="/copies/store" method="POST">
        <div class="row mt-3">
            <div class="col-1">
                <label for="movie" class="mt-1">Film</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="movie" name="movie">
                    <option selected>Odaberi</option>
                        <?php foreach ($movies as $movie): ?>
                            <option value="<?= $movie['id'] ?>"><?= $movie['naslov'] . ' (' . $movie['godina'] . ')' ?></option>
                        <?php endforeach ?>
                </select>
                <span class="text-danger small"><?= $errors['film_id'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="dvd" class="mt-1">DVD količina</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="dvd" name="dvd" value="<?= $data['dvd'] ?? '' ?>">
                <span class="text-danger small"><?= $errors['dvd'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="blu-ray" class="mt-1">Blu-ray količina</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="blu-ray" name="blu-ray" value="<?= $data['blu-ray'] ?? '' ?>">
                <span class="text-danger small"><?= $errors['blu-ray'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="vhs" class="mt-1">VHS količina</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="vhs" name="vhs" value="<?= $data['vhs'] ?? '' ?>">
                <span class="text-danger small"><?= $errors['vhs'] ?? '' ?></span>
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="/copies" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php') ?>  