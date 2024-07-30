<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1><?= $media['tip'] ?></h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row mt-3">
            <div class="col-1">
                <label for="id" class="mt-1">Id medija</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="<?= $media['id'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="type" class="mt-1">Naziv medija</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="type" name="type" value="<?= $media['tip'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="coefficient" class="mt-1">Koeficijent</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="coefficient" name="coefficient" value="<?= $media['koeficijent'] ?>" disabled>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-2">
        <a href="/media" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
        <a href="/media/edit?id=<?= $media['id'] ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
        <form id="delete-form" class="hidden d-inline" method="POST" action="/media/destroy">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $media['id'] ?>">
            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
        </form>    
    </div>
    <hr>
    <h2><?= $media['tip'] ?> filmovi</h2>
    <hr>
    <div class="overflow-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Naslov</th>
                    <th>Godina</th>
                    <th>Žanr</th>
                    <th>Tip</th>
                    <th>Količina</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?= $movie['id'] ?></td>
                        <td><a href="/movies/show?id=<?= $movie['id'] ?>"><?= $movie['naslov'] ?></a></td>
                        <td><?= $movie['godina'] ?></td>
                        <td><?= $movie['zanr'] ?></td>
                        <td><?= $movie['tip'] ?></td>
                        <td><?= $movie['kolicina'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>

<?php include_once basePath('views/partials/footer.php') ?>