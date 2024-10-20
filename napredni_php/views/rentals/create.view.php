<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Dodaj novu posudbu</h1>
    <hr>
    <form class="row g-3 mt-3" action="/rentals" method="POST">
        <div class="row mt-3">
            <div class="col-1">
                <label for="member" class="mt-1">Član</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="member" name="member">
                    <option selected>Odaberi</option>
                        <?php foreach ($members as $member): ?>
                            <option value="<?= $member['clan_id'] ?>"><?= $member['ime'] . ' ' . $member['prezime'] . ' (' . $member['clanski_broj'] . ')' ?></option>
                        <?php endforeach ?>
                </select>
                <span class="text-danger small"><?= $errors['clan_id'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="movie_media" class="mt-1">Kopija filma</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="movie_media" name="movie_media">
                    <option selected>Odaberi</option>
                        <?php foreach ($copies as $copy): ?>
                            <option value="<?= $copy['film_id'] . '-' . $copy['medij_id'] ?>"><?= $copy['naslov'] . ' (' . $copy['godina'] . ') - ' . $copy['medij'] . ' (' . $copy['kolicina'] . ')' ?></option>
                        <?php endforeach ?>
                </select>
                <span class="text-danger small"><?= $errors['film_id'] ?? '' ?></span>
                <span class="text-danger small"><?= $errors['medij_id'] ?? '' ?></span>
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="/rentals" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php') ?>  