<?php
include BASE_DIR . 'header.php';
require_once CONTROLLERS_DIR . 'News.php';

$news = null;
if (isset($_GET['id'])) {
    $news = News::get_news_by_id($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $image = $_FILES['image'];

    $image_name = uniqid() . '_' . $image['name'];
    $destination = IMAGE_DIR . $image_name;

    if (move_uploaded_file($image['tmp_name'], $destination)) {
        if ($news) {
            $news->setTitle($title);
            $news->setDescription($description);
            $news->setImage($image_name);
            $news->update();
        }

        header('Location: /news');
        exit();
    } else {
        echo 'Error while uploading image.';
    }
}
?>

    <div class="container w-50 p-3">
        <h1 class="mx-auto text-center p-2">Atjaunot ziņu</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label for="title">Nosaukums:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $news ? $news->getTitle() : ''; ?>" required>
            </div>

            <div class="form-group mb-2">
                <label for="description">Apraksts:</label>
                <textarea class="form-control" id="description" name="description" rows="15" required><?php echo $news ? $news->getDescription() : ''; ?></textarea>
            </div>

            <div class="form-group mb-2">
                <label for="image">Attēls:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary mx-auto d-block mt-4">Atjaunot</button>
        </form>
    </div>

<?php include BASE_DIR . 'footer.php' ?>