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
        <a href="/media" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Svi mediji"><i class="bi bi-arrow-return-left"></i></a>
        <a href="/media/edit?id=<?= $media['id'] ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi medij"><i class="bi bi-pencil"></i></a>
    </div>
</main>

<?php include_once basePath('views/partials/footer.php') ?>