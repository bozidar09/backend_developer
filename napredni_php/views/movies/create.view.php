<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Dodaj novi film</h1>
    <hr>
    <form class="row g-3 mt-3" action="/movies" method="POST">
        <div class="row mt-3">
            <div class="col-1">
                <label for="title" class="mt-1">Naslov</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="title" name="title" value="<?= $old['naslov'] ?? '' ?>" required>
                <span class="text-danger small"><?= $errors['naslov'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="year" class="mt-1">Godina</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="year" name="year" value="<?= $old['godina'] ?? '' ?>" required>
                <span class="text-danger small"><?= $errors['godina'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="genre" class="mt-1">Žanr</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="genre" name="genre">
                    <option selected>Odaberi</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= $genre['id'] ?>"><?= $genre['ime'] ?></option>
                        <?php endforeach ?>
                </select>
                <span class="text-danger small"><?= $errors['zanr_id'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="movie_type" class="mt-1">Tip filma</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="movie_type" name="movie_type">
                    <option selected>Odaberi</option>
                        <?php foreach ($movieTypes as $movieType): ?>
                            <option value="<?= $movieType['id'] ?>"><?= $movieType['tip_filma'] ?></option>
                        <?php endforeach ?>
                </select>
                <span class="text-danger small"><?= $errors['cjenik_id'] ?? '' ?></span>
            </div>
        </div>
        <hr>
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
            <a href="/movies" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php') ?>               