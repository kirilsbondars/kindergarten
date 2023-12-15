<?php
include(BASE_DIR . 'header.php');
require_once(CONTROLLERS_DIR . 'User.php');

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::login($username, $password);
    if($user) {
        $_SESSION['user_id'] = $user->getId();
        header('Location: /news');
    } else {
        $errors[] = 'Nepareizs lietotājvārds vai parole!';
    }
}
?>

    <div class="container w-50 p-3">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="/sign_up" type="button" class="btn btn-outline-secondary">Lietotāja reģistrācija</a>
        </div>

        <h1 class="mx-auto text-center p-2">Ielogoties</h1>
        <form method="POST">
            <div class="form-group mb-2">
                <label for="username">Lietotājvārds:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group mb-4">
                <label for="password">Parole:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <?php foreach($errors as $error) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <button type="submit" class="btn btn-primary mx-auto d-block">Ielogoties</button>
        </form>
    </div>

<?php include(BASE_DIR . 'footer.php'); ?>