<?php
global $current_user;
include(BASE_DIR . 'header.php');
require_once(CONTROLLERS_DIR . 'News.php');
require_once(CONTROLLERS_DIR . 'User.php');
require_once (CONTENT_DIR . 'functions.php');

$search = $_GET['search'] ?? null;
$all_news = News::get_all($search);
?>

    <div class="container w-50 d-flex justify-content-center align-items-center mb-3">
        <div class="row">
            <div class="col">
                <form action="/news" method="get" class="input-group">
                    <input type="text" name="search" placeholder="Search news" class="form-control">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>

    <?php if(is_user_and_admin()) { ?>
    <div class="container w-50 d-flex justify-content-center align-items-center mb-3">
        <div class="row">
            <div class="col">
                <a href="/news_article/create" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Pievienot jaunu</a>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="col-lg-6 col-md-10">
            <?php foreach ($all_news as $news_item) { ?>
            <div class="card mb-3">
                <img src="/img/<?php echo $news_item->getImage() ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $news_item->getTitle() ?></h5>
                    <p class="card-text"><?php echo $news_item->getDescription() ?></p>
                    <p class="card-text"><small class="text-body-secondary"><?php echo $news_item->getCreatedAt() ?></small></p>
                    <p class="card-text">
                        <small class="text-body-secondary"><a href="/news_article/view/<?php echo $news_item->getId() ?>">Vairāk</a></small>
                        <?php if(is_user_and_admin()) { ?>
                        <small class="text-body-secondary"><a href="/news_article/update/<?php echo $news_item->getId() ?>">Rediģēt</a></small>
                        <small class="text-body-secondary"><a href="/news_article/delete/<?php echo $news_item->getId() ?>">Nodzēst</a></small>
                        <?php } ?>
                    </p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

<?php include(BASE_DIR . 'footer.php'); ?>