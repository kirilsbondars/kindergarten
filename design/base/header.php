<?php global $current_user; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-md bg-body-tertiary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="/news">Bērnudarzs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/news">Ziņu dēlis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Viesu grāmata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/teachers">Mūsu pedagogi</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <?php if($current_user): ?>
                        <span class="me-3"><?php echo $current_user->getFullName(); ?></span>
                        <a href="/logout" class="btn btn-outline-secondary">Iziet</a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-secondary">Ielogoties</a>
                        <a href="/sign_up" class="btn btn-outline-secondary">Reģistrēties</a>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </nav>

    <div class="container w-50">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </div>
