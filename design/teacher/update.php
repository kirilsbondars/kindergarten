<?php
include BASE_DIR . 'header.php';
require_once CONTROLLERS_DIR . 'Teacher.php';

$teacher = null;
if (isset($_GET['id'])) {
    $teacher = Teacher::getTeacherById($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $age = htmlspecialchars($_POST['age']);
    $description = htmlspecialchars($_POST['description']);

    if (!empty($_FILES['new_image']['name'])) {
        $image = $_FILES['new_image'];
        $image_name = uniqid() . '_' . $image['name'];
        $destination = IMAGE_DIR . $image_name;

        if (move_uploaded_file($image['tmp_name'], $destination)) {
            $teacher->deleteImage();
            $teacher->setImage($image_name);
        } else {
            echo 'Kļūda, augšupielādējot attēlu.';
        }
    }

    if ($teacher) {
        $teacher->setName($name);
        $teacher->setSurname($surname);
        $teacher->setAge($age);
        $teacher->setDescription($description);
        if($teacher->update()) {
            $_SESSION['success_message'] = 'Skolotājs "' . $teacher->getFullName() . '" tika atjaunināts.';
        }
    }

    header('Location: /teachers');
    exit();
}
?>

    <div class="container w-50 p-3">
        <h1 class="mx-auto text-center p-2">Atjaunot informāciju par pedagogu</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label for="name">Vārds:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $teacher ? $teacher->getName() : ''; ?>" required>
            </div>

            <div class="form-group mb-2">
                <label for="surname">Uzvārds:</label>
                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $teacher ? $teacher->getSurname() : ''; ?>" required>
            </div>

            <div class="form-group mb-2">
                <label for="age">Vecums:</label>
                <input type="number" class="form-control" id="age" name="age" min="18" max="150" value="<?php echo $teacher ? $teacher->getAge() : ''; ?>" required>
            </div>

            <div class="form-group mb-2">
                <label for="description">Apraksts:</label>
                <textarea class="form-control" id="description" name="description" rows="10" required><?php echo $teacher ? $teacher->getDescription() : ''; ?></textarea>
            </div>

            <div class="form-group mb-2">
                <label for="image">Tekošais attēls:</label>
                <div class="text-center">
                    <img src="/img/<?php echo $teacher ? $teacher->getImage() : ''; ?>" alt="Current Image" width="75%">
                </div>
            </div>

            <div class="form-group mb-2">
                <label for="new_image">Jaunais attēls:</label>
                <input type="file" class="form-control" id="new_image" name="new_image" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary mx-auto d-block mt-4">Atjaunot</button>
        </form>
    </div>

<?php include BASE_DIR . 'footer.php' ?>