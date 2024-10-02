<?php include_once basePath('views/partials/header.php'); ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Uredi žanr</h1>
    <hr>
    <form class="row g-3 mt-3" action="/genres" method="POST">
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="<?= $genre['id'] ?>">
        <div class="col-1">
            <label for="name" class="mt-1">Naziv žanra</label>
        </div>
        <div class="col-6">
            <input type="text" class="form-control" id="name" name="name" value="<?= $genre['ime'] ?>" required>
            <span class="text-danger small"><?= $errors['ime'] ?? '' ?></span>
        </div>
        <hr>
        <div class="col-6">
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php'); ?>