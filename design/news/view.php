<?php
include BASE_DIR . 'header.php';
require_once CONTROLLERS_DIR . 'News.php';

$news = null;
if (isset($_GET['id'])) {
    $news = News::get_news_by_id($_GET['id']);
}

?>

    <div class="container w-50 p-3">
        <h1 class="mx-auto text-center p-2">Skatīt ziņu</h1>
        <form>
            <div class="form-group mb-2">
                <label for="title">Nosaukums:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $news ? $news->getTitle() : ''; ?>" readonly>
            </div>

            <div class="form-group mb-2">
                <label for="description">Apraksts:</label>
                <textarea class="form-control" id="description" name="description" rows="15" readonly><?php echo $news ? $news->getDescription() : ''; ?></textarea>
            </div>

            <div class="form-group mb-2">
                <label for="image">Attēls:</label>
                <div class="text-center">
                    <img src="/img/<?php echo $news ? $news->getImage() : ''; ?>" alt="Current Image" width="75%">
                </div>
            </div>
        </form>
    </div>

<?php include BASE_DIR . 'footer.php' ?>