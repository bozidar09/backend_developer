<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1><?= $price['tip_filma'] ?></h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row">
            <div class="col-1">
                <label for="id" class="mt-1">Id tipa filma</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="<?= $price['id'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="movie_type" class="mt-1">Tip filma</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="movie_type" name="movie_type" value="<?= $price['tip_filma'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="price" class="mt-1">Cijena</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="price" name="price" value="<?= $price['cijena'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="late_fee" class="mt-1">Zakasnina</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="late_fee" name="late_fee" value="<?= $price['zakasnina_po_danu'] ?>" disabled>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-2">
        <a href="/prices" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
        <a href="/prices/edit?id=<?= $price['id'] ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
        <form id="delete-form" class="hidden d-inline" method="POST" action="/prices/destroy">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $price['id'] ?>">
            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
        </form>
    </div>
    <hr>
    <h2><?= $price['tip_filma'] ?> filmovi</h2>
    <hr>
    <div class="overflow-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Naslov</th>
                    <th>Godina</th>
                    <th>Žanr</th>
                    <th>Medij</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?= $movie['id'] ?></td>
                        <td><a href="/movies/show?id=<?= $movie['id'] ?>"><?= $movie['naslov'] ?></a></td>
                        <td><?= $movie['godina'] ?></td>
                        <td><?= $movie['zanr'] ?></td>
                        <td>
                            <?php foreach ($movie['medij'] as $medij): ?>
                                <?php 
                                    $medijIcon = match ($medij) {
                                        'DVD' => 'disc-fill text-warning',
                                        'Blu-ray' => 'disc text-primary',
                                        'VHS' => 'cassette-fill text-success',
                                        default => ''
                                    }; 
                                ?>
                                <span class="badge text-bg-light float-start"><i class="bi bi-<?= $medijIcon ?> me-1"></i><?= $medij ?></span>
                            <?php endforeach ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>

<?php include_once basePath('views/partials/footer.php') ?>

