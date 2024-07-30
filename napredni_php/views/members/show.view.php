<?php include_once basePath('views/partials/header.php') ?>

<main class="container my-3 d-flex flex-column flex-grow-1 vh-100">
    <h1><?= $member['ime'] ?> <?= $member['prezime'] ?></h1>
    <hr>
    <form class="row g-3 mt-3">
        <div class="row mt-3">  
            <div class="col-1">
                <label for="id" class="mt-1">Id člana</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="id" name="id" value="<?= $member['id'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="member_id" class="mt-1">Članski broj</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="member_id" name="member_id" value="<?= $member['clanski_broj'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="name" class="mt-1">Ime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="name" name="name" value="<?= $member['ime'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="surname" class="mt-1">Prezime</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="surname" name="surname" value="<?= $member['prezime'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="address" class="mt-1">Adresa</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="address" name="address" value="<?= $member['adresa'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="phone" class="mt-1">Telefonski broj</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $member['telefon'] ?>" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <label for="email" class="mt-1">Email</label>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="email" name="email" value="<?= $member['email'] ?>" disabled>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-2">
        <a href="/members" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Povratak"><i class="bi bi-arrow-return-left"></i></a>
        <a href="/members/edit?id=<?= $member['id'] ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uredi"><i class="bi bi-pencil"></i></a>
        <form id="delete-form" class="hidden d-inline" method="POST" action="/members/destroy">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $member['id'] ?>">
            <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Izbriši"><i class="bi bi-trash"></i></button>
        </form>
    </div>
    <hr>
    <h2><?= $member['ime'] ?> <?= $member['prezime'] ?> trenutne posudbe</h2>
    <hr>
    <div class="overflow-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Datum</th>
                    <th>Naslov</th>
                    <th>Godina</th>
                    <th>Žanr</th>
                    <th>Medij</th>
                    <th>Cijena</th>
                    <th>Zakasnina</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rentals as $rental): ?>
                    <tr>
                        <td><?= $rental['id'] ?></td>
                        <td><a href="/rentals/show?id=<?= $rental['id'] ?>"><?= $rental['datum'] ?></a></td>
                        <td><?= $rental['naslov'] ?></td>
                        <td><?= $rental['godina'] ?></td>
                        <td><?= $rental['zanr'] ?></td>
                        <td><?= $rental['medij'] ?></td>
                        <td><?= $rental['cijena'] ?></td>
                        <td><?= $rental['zakasnina'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>

<?php include_once basePath('views/partials/footer.php') ?>