<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1">
    <div class="title flex-between">    
        <h1>Posudbe</h1>
        <div class="action-buttons">
            <a href="/rentals/create" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
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
                <th>Posudba - povrat</th>
                <th>Član</th>
                <th>Naslov</th>
                <th>Cijena - zakasnina (€)</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rentals as $rental): ?>
                <tr>
                    <td><?= $rental['id'] ?></td>
                    <td><a href="/rentals/show?id=<?= $rental['id'] ?>&movie=<?= $rental['film_id'] ?>"><?= $rental['datum_posudbe'] ?> - <?= $rental['datum_povrata'] ?? '' ?></a></td>
                    <td><?= $rental['ime'] . ' ' . $rental['prezime'] . ' (' . $rental['clanski_broj'] . ')' ?></td>
                    <td><?= $rental['naslov'] . ' (' . $rental['godina'] . ') - ' . $rental['medij'] ?></td>
                    <td><?= $rental['cijena'] . ' - ' . $rental['zakasnina'] ?></td>
                    <td>
                        <a href="/rentals/edit?id=<?= $rental['id'] ?>&movie=<?= $rental['film_id'] ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="/rentals/destroy">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="pid" value="<?= $rental['id'] ?>">
                            <input type="hidden" name="kid" value="<?= $rental['kopija_id'] ?>">
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>

<?php include_once basePath('views/partials/footer.php') ?>