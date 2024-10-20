<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1">
    <h1>Nova posudba</h1>
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
                            <option value="<?= $copy['film_id'] . '-' .$copy['medij_id'] ?>"><?= $copy['naslov'] . ' (' . $copy['godina'] . ') - ' . $copy['medij'] . ' (' . $copy['kolicina'] . ')' ?></option>
                        <?php endforeach ?>
                </select>
                <span class="text-danger small"><?= $errors['film_id'] ?? '' ?></span>
                <span class="text-danger small"><?= $errors['medij_id'] ?? '' ?></span>
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
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $message['type'] ?> alert-dismissible fade show" role="alert">
            <?= $message['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>  
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Posudba - povrat</th>
                <th>Član</th>
                <th>Naslov</th>
                <th>Cijena - zakasnina (€)</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rentals as $rental): ?>
                <tr>
                    <td><?= $rental['id'] ?></td>
                    <td><a href="/rentals/show?id=<?= $rental['id'] ?>&movie=<?= $rental['film_id'] ?>"><?= $rental['datum_posudbe'] ?> - <?= $rental['datum_povrata'] ?? '' ?></a></td>
                    <td><?= $rental['ime'] . ' ' . $rental['prezime'] . ' (' . $rental['clanski_broj'] . ')' ?></td>
                    <td><?= $rental['naslov'] . ' (' . $rental['godina'] . ') - ' . $rental['medij'] ?></td>
                    <td><?= $rental['cijena'] . ' - ' . $rental['zakasnina'] ?></td>
                    <td>
                        <form action="/rentals/return" method="POST" class="d-inline">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="pid" value="<?= $rental['id'] ?>">
                            <input type="hidden" name="kid" value="<?= $rental['kopija_id'] ?>">
                            <button type="submit" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Oznaci vraceno"><i class="bi bi-arrow-counterclockwise"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>

<?php include_once basePath('views/partials/footer.php') ?>