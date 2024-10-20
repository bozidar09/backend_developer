<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1><?= $movie['naslov'] ?></h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row mt-3">
            <div class="col-1">
                <label for="id" class="mt-1">Id filma</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="<?= $movie['id'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="title" class="mt-1">Naslov</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="title" name="title" value="<?= $movie['naslov'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="year" class="mt-1">Godina</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="year" name="year" value="<?= $movie['godina'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="genre" class="mt-1">Žanr</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="genre" name="genre" value="<?= $movie['zanr'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="media" class="mt-1">Mediji</label>
            </div>
            <div class="col-6">
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
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="movie_type" class="mt-1">Tip filma</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="movie_type" name="movie_type" value="<?= $movie['tip'] ?>" disabled>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-2">
        <a href="/movies" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
        <a href="/movies/edit?id=<?= $movie['id'] ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
        <form id="delete-form" class="hidden d-inline" method="POST" action="/movies/destroy">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $movie['id'] ?>">
            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
        </form>
    </div>
    <hr>
    <h2><?= $movie['naslov'] ?> kopije</h2>
    <hr>
    <div class="overflow-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Barkod</th>
                    <th>Medij</th>
                    <th>Dostupan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($copies as $copy): ?>
                    <tr>
                        <td><?= $copy['id'] ?></td>
                        <td><?= $copy['barcode'] ?></td>
                        <td><?= $copy['medij'] ?></td>
                        <td><?= $copy['dostupan'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

</main>

<?php include_once basePath('views/partials/footer.php') ?>