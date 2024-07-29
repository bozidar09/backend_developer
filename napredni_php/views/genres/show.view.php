<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1><?= $genre['ime'] ?></h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row mt-3">
            <div class="col-1">
                <label for="id" class="mt-1">Id žanra:</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="<?= $genre['id'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="name" class="mt-1">Naziv žanra:</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="name" name="name" value="<?= $genre['ime'] ?>" disabled>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-2">
        <a href="/genres" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Svi žanrovi"><i class="bi bi-arrow-return-left"></i></a>
        <a href="/genres/edit?id=<?= $genre['id'] ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi žanr"><i class="bi bi-pencil"></i></a>
    </div>
</main>

<?php include_once basePath('views/partials/footer.php') ?>