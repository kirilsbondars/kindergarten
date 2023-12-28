<?php
global $current_user;
include(BASE_DIR . 'header.php');
require_once(CONTROLLERS_DIR . 'News.php');
require_once(CONTROLLERS_DIR . 'User.php');
require_once (CONTENT_DIR . 'functions.php');

$search = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'DESC';
$all_news = News::get_all($search, $order);
?>

    <?php if(isUserAndAdmin()) { ?>
    <div class="container w-50 d-flex justify-content-center align-items-center mb-3">
        <div class="row">
            <div class="col">
                <a href="/news_article/create" class="btn btn-primary" role="button" aria-pressed="true">Pievienot jaunu ziņu</a>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="col-lg-6 col-md-10">
            <form action="/news" method="get" class="input-group mb-4">
                <input type="text" name="search" placeholder="Meklēt" class="form-control" id="search-input" value="<?php echo $search ?>">
                <select name="order" class="form-select" onchange="this.form.submit()">
                    <option value="DESC" <?php echo $order === 'DESC' ? 'selected' : '' ?>>Jaukakas ziņas</option>
                    <option value="ASC" <?php echo $order === 'ASC' ? 'selected' : '' ?>>Vecākas ziņas</option>
                </select>
                <button type="submit" class="btn btn-primary" id="search-button">Meklēt</button>
                <a href="/news" class="btn btn-secondary" role="button" aria-pressed="true" id="remove-button">Nodzest</a>
            </form>
        </div>
    </div>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="col-lg-6 col-md-10">

            <?php if (empty($all_news)) { ?>
                <p>Nevienas ziņas netika atrasts. :(</p>
            <?php } ?>

            <?php foreach ($all_news as $news_item) { ?>
            <div class="card mb-3">
                <img src="/img/<?php echo $news_item->getImage() ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $news_item->getTitle() ?></h5>
                    <p class="card-text"><?php echo $news_item->getDescription() ?></p>
                    <p class="card-text"><small class="text-body-secondary"><?php echo $news_item->getCreatedAt() ?></small></p>
                    <p class="card-text">
                        <small class="text-body-secondary"><a href="/news_article/view/<?php echo $news_item->getId() ?>">Vairāk</a></small>
                        <?php if(isUserAndAdmin()) { ?>
                        <small class="text-body-secondary"><a href="/news_article/update/<?php echo $news_item->getId() ?>">Rediģēt</a></small>
                        <small class="text-body-secondary"><a href="/news_article/delete/<?php echo $news_item->getId() ?>" onclick="return confirm('Vai tiešām vēlaties dzēst šo ziņu?')">Nodzēst</a></small>
                        <?php } ?>
                    </p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <script>
        let searchInput = document.getElementById('search-input');
        let searchButton = document.getElementById('search-button');

        searchButton.disabled = !searchInput.value;

        searchInput.addEventListener('input', function() {
            searchButton.disabled = !this.value;
        });
    </script>

<?php include(BASE_DIR . 'footer.php'); ?>