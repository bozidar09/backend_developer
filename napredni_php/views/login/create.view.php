<?php include_once basePath('views/partials/home-header.php') ?> 

<main class="container my-3 d-flex flex-column flex-grow-1">
    <div class="container py-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <h1>Prijava</h1>
            <?php if (!empty($message)): ?>
                <div class="alert alert-<?= $message['type'] ?> alert-dismissible fade show" role="alert">
                    <?= $message['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <hr>
            <div class="container-fluid">
                <form class="row g-3 mt-3" action="/login" method="POST">
                    <div class="row mt-3">
                        <div class="col-1">
                            <label for="email" class="mt-1">Email</label>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" id="email" name="email" value="<?= $old['email'] ?? '' ?>" required>
                            <span class="text-danger small"><?= $errors['email'] ?? '' ?></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-1">
                            <label for="password" class="mt-1">Lozinka</label>
                        </div>
                        <div class="col-6">
                            <input type="password" class="form-control" id="password" name="password" value="<?= $old['password'] ?? '' ?>" required>
                            <span class="text-danger small"><?= $errors['password'] ?? '' ?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="col-auto">
                        <a href="/" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
                        <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ulogiraj se">Ulogiraj se</button>
                    </div>
                </form>
            </div>
        </div>

<?php include_once basePath('views/partials/home-footer.php') ?>  