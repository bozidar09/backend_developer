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
    <hr>
    <h2><?= $genre['ime'] ?> filmovi</h2>
    <div class="overflow-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Naslov</th>
                    <th>Godina</th>
                    <th>Medij</th>
                    <th>Tip</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?= $movie['id'] ?></td>
                        <td><a href="/movies/show?id=<?= $movie['id'] ?>"><?= $movie['naslov'] ?></a></td>
                        <td><?= $movie['godina'] ?></td>
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
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>

<?php include_once basePath('views/partials/footer.php') ?>