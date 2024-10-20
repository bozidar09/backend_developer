<?php include_once basePath('views/partials/header.php'); ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Uredi člana</h1>
    <hr>
    <form class="row g-3 mt-3" action="/members" method="POST">
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="<?= $member['id'] ?>">
        <div class="row mt-3">
            <div class="col-1">
                <label for="member_id" class="mt-1">Članski broj</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="member_id" name="member_id" value="<?= $member['clanski_broj'] ?>" required>
                <span class="text-danger small"><?= $errors['clanski_broj'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="name" class="mt-1">Ime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="name" name="name" value="<?= $member['ime'] ?>" required>
                <span class="text-danger small"><?= $errors['ime'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="surname" class="mt-1">Prezime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="surname" name="surname" value="<?= $member['prezime'] ?>" required>
                <span class="text-danger small"><?= $errors['prezime'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="address" class="mt-1">Adresa</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="address" name="address" value="<?= $member['adresa'] ?>">
                <span class="text-danger small"><?= $errors['adresa'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="phone" class="mt-1">Telefonski broj</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $member['telefon'] ?>">
                <span class="text-danger small"><?= $errors['telefon'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="email" class="mt-1">Email</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="email" name="email" value="<?= $member['email'] ?>" required>
                <span class="text-danger small"><?= $errors['email'] ?? '' ?></span>
            </div>
        </div>
        <hr>
        <div class="col-auto">
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
            <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Spremi"><i class="bi bi-floppy"></i></button>
        </div>
    </form>
</main>

<?php include_once basePath('views/partials/footer.php'); ?>