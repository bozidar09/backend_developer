<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1">
    <div class="title flex-between">    
        <h1>Filmovi</h1>
        <div class="action-buttons">
            <a href="/movies/create" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj"><i class="bi bi-plus-lg"></i></a>
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
                <th>Godina</th>
                <th>Žanr</th>
                <th>Medij</th>
                <th>Tip</th>
                <th class="table-action-col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?= $movie['id'] ?></td>
                    <td><a href="/movies/show?id=<?= $movie['id'] ?>"><?= $movie['naslov'] ?></a></td>
                    <td><?= $movie['godina'] ?></td>
                    <td><?= $movie['zanr'] ?></td>
                    <td>
                        <?php foreach ($movie['medij'] as $medij): ?>
                            <?php 
                                $medijIcon = match ($medij) {
                                    'DVD' => 'disc-fill text-warning',
                                    'Blu-ray' => 'disc text-primary',
                                    'VHS' => 'cassette-fill text-success',
                                    default => ''
                                }; 
                            ?>
                            <span class="badge text-bg-light float-start"><i class="bi bi-<?= $medijIcon ?> me-1"></i><?= $medij ?></span>
                        <?php endforeach ?>
                    </td>
                    <td><?= $movie['tip'] ?></td>
                    <td>
                        <a href="/movies/edit?id=<?= $movie['id'] ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
                        <form id="delete-form" class="hidden d-inline" method="POST" action="/movies/destroy">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?= $movie['id'] ?>">
                            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>

<?php include_once basePath('views/partials/footer.php') ?>  