<?php include_once basePath('views/partials/header.php'); ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1>Uredi kopiju #<?= $copy['id'] ?></h1>
    <hr>
    <form class="row g-3 mt-3" action="/copies" method="POST">
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="<?= $copy['id'] ?>">
        <div class="row mt-3">
            <div class="col-1">
                <label for="barcode" class="mt-1">Barkod</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="barcode" name="barcode" value="<?= $copy['barcode'] ?>" required>
                <span class="text-danger small"><?= $errors['barcode'] ?? '' ?></span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="available" class="mt-1">Dostupan</label>
            </div>
            <div class="col-6">
                <select class="form-select form-select mb-2" id="available" name="available">
                    <option selected value="<?= $copy['dostupan'] ?>"><?= $copy['dostupan'] ?></option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                </select>
                <span class="text-danger small"><?= $errors['dostupan'] ?? '' ?></span>
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