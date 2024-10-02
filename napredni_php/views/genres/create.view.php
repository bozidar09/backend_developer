<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Dodaj novi žanr</h1>
    <hr>
    <form class="row g-3 mt-3" action="/genres" method="POST">
        <div class="col-1">
            <label for="name" class="mt-1">Naziv žanra</label>
        </div>
        <div class="col-6">
            <input type="text" class="form-control" id="name" name="name" value="<?= $old['ime'] ?? '' ?>" required>
            <span class="text-danger small"><?= $errors['ime'] ?? '' ?></span>
        </div>
        <hr>
        <div class="col-auto">
            <a href="/genres" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php') ?>