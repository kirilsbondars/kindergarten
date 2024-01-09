<?php
require_once CONTROLLERS_DIR . 'Teacher.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $age = htmlspecialchars($_POST['age']);
    $description = htmlspecialchars($_POST['description']);
    $image = $_FILES['image'];

    $image_name = uniqid() . '_' . $image['name'];
    $destination = IMAGE_DIR . $image_name;

    if (move_uploaded_file($image['tmp_name'], $destination)) {
        $teacher = new Teacher(null, $name, $surname, $age, $description, $image_name);
        $result = $teacher->create();

        if ($result) {
            $_SESSION['success_message'] = 'Jauns skolotājs "' . $teacher->getFullName() . '" tika izveidots.';
            header('Location: /teachers');
            exit();
        } else {
            echo 'Kļūda, veidojot skolotāju.';
        }
    } else {
        echo 'Kļūda, augšupielādējot attēlu.';
    }
}

$title = 'Pievienot jaunu pedadogu sarakstam';
include(BASE_DIR . 'header.php');
?>

    <div class="container w-50 p-3">
        <h1 class="mx-auto text-center p-2"><?php echo $title; ?></h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label for="name">Vārds:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group mb-2">
                <label for="surname">Uzvārds:</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>

            <div class="form-group mb-2">
                <label for="age">Vecums:</label>
                <input type="number" class="form-control" id="age" name="age" min="18" max="150" required>
            </div>

            <div class="form-group mb-2">
                <label for="description">Apraksts:</label>
                <textarea class="form-control" id="description" name="description" rows="10" required></textarea>
            </div>

            <div class="form-group mb-2">
                <label for="image">Attēls:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary mx-auto d-block mt-4">Pievienot</button>
        </form>
    </div>

<?php include BASE_DIR . 'footer.php' ?>