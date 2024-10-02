<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1">
    <div class="title flex-between">    
        <h1>Količine</h1>
        <div class="action-buttons">
            <a href="/copies/create" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
        </div>
    </div>
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $message['type'] ?> alert-dismissible fade show" role="alert">
            <?= $message['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Naslov</th>
                <th>Barkod</th>
                <th>Medij</th>
                <th>Količina</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($amountAll as $amount): ?>
                <tr>
                    <td><?= $amount['id'] ?></td>
                    <td><a href="/copies/show?barcode=<?= $amount['barcode'] ?>&media=<?= $amount['medij_id'] ?>"><?= $amount['naslov'] ?></a></td>
                    <td><?= $amount['barcode'] ?></td>
                    <td><?= $amount['medij'] ?></td>
                    <td><?= $amount['kolicina'] ?></td>
                    <td>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="/copies/destroy">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="code" value="<?= $amount['barcode'] ?>">
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>

<?php include_once basePath('views/partials/footer.php') ?>  