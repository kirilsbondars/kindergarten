<?php
include BASE_DIR . 'header.php';
require_once CONTROLLERS_DIR . 'User.php';


$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm-password']);

    if(!empty(User::get_user_by_username($username))) {
        $errors['username'] = 'Lietotājs ar šādu lietotājvārdu jau eksistē.';
    }

    if($password !== $confirm_password) {
        $errors['confirm-password'] = 'Paroles nesakrīt.';
    }

    if(empty($errors)) {
        $user = new User(null, $name, $surname, $username, $password, 'user');

        if($user->create()) {
            header('Location: /login');
            exit();
        } else {
            echo 'Kļūda reģistrācijas laikā.';
        }
    }
}
?>

    <div class="container w-50 p-3">
        <h1 class="mx-auto text-center p-2">Reģistrēties</h1>
        <form method="POST">
            <div class="form-group mb-2">
                <label for="name">Vārds:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?? ''; ?>" required>
            </div>

            <div class="form-group mb-2">
                <label for="surname">Uzvārds:</label>
                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $surname ?? ''; ?>" required>
            </div>

            <div class="form-group mb-2">
                <label for="username">Lietotājvārds:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?? ''; ?>" required>
                <?php if(isset($errors['username'])): ?>
                    <small class="form-text text-danger"><?php echo $errors['username']; ?></small>
                <?php endif; ?>
            </div>

            <div class="form-group mb-2">
                <label for="password">Parole:</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?? ''; ?>" required>
            </div>

            <div class="form-group mb-2">
                <label for="confirm-password">Atkartot paroli:</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" value="<?php echo $confirm_password ?? ''; ?>" required>
                <?php if(isset($errors['confirm-password'])): ?>
                    <small class="form-text text-danger"><?php echo $errors['confirm-password']; ?></small>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary mx-auto d-block mt-4">Reģistrēties</button>
        </form>
    </div>

<?php include BASE_DIR . 'footer.php' ?>