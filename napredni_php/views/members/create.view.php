<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Dodaj novog člana</h1>
    <hr>
    <form class="row g-3 mt-3" action="/members" method="POST">
        <div class="row mt-3">
            <div class="col-1">
                <label for="name" class="mt-1">Ime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="name" name="name" value="<?= $old['ime'] ?? '' ?>" required>
                <span class="text-danger small"><?= $errors['ime'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="surname" class="mt-1">Prezime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="surname" name="surname" value="<?= $old['prezime'] ?? '' ?>" required>
                <span class="text-danger small"><?= $errors['prezime'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="address" class="mt-1">Adresa</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="address" name="address" value="<?= $old['adresa'] ?? '' ?>" >
                <span class="text-danger small"><?= $errors['adresa'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="phone" class="mt-1">Telefonski broj</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $old['telefon'] ?? '' ?>">
                <span class="text-danger small"><?= $errors['telefon'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="email" class="mt-1">Email</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="email" name="email" value="<?= $old['email'] ?? '' ?>" required>
                <span class="text-danger small"><?= $errors['email'] ?? '' ?></span>
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="/members" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php') ?>               