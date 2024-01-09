<?php
require_once CONTROLLERS_DIR . 'News.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $image = $_FILES['image'];

    $image_name = uniqid() . '_' . $image['name'];
    $destination = IMAGE_DIR . $image_name;

    if (move_uploaded_file($image['tmp_name'], $destination)) {
        $news = News::createNews($title, $image_name, $description);

        if ($news->create()) {
            $_SESSION['success_message'] = 'Jauna ziņa "' . $news->getTitle() . '" tika izveidota.';
            header('Location: /news');
            exit();
        } else {
            echo 'Kļūda, veidojot ziņu.';
        }
    } else {
        echo 'Kļūda, augšupielādējot attēlu';
    }
}

$title = 'Izveidot jaunu ziņu';
include(BASE_DIR . 'header.php');
?>

    <div class="container w-50 p-3">
        <h1 class="mx-auto text-center p-2">Izveidot jaunu ziņu</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label for="title">Nosaukums:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group mb-2">
                <label for="description">Apraksts:</label>
                <textarea class="form-control" id="description" name="description" rows="15" required></textarea>
            </div>

            <div class="form-group mb-2">
                <label for="image">Attēls:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary mx-auto d-block mt-4">Izveidot</button>
        </form>
    </div>

<?php include BASE_DIR . 'footer.php' ?>