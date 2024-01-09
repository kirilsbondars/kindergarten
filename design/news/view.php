<?php
require_once CONTROLLERS_DIR . 'News.php';

$news_id = $_GET['id'];

$news = News::get_news_by_id($news_id);

if (!$news) {
    $_SESSION['success_message'] = "Ziņa id '$news_id' netika atrasta ar";
    header('Location: /news');
}

$title = $news->getTitle();
include(BASE_DIR . 'header.php');
?>

    <div class="container w-50 px-3">
        <h1 class="mx-auto text-center p-2"><?php echo $news->getTitle(); ?></h1>
        <img src="<?php echo '/img/' . $news->getImage(); ?>" alt="<?php echo $news->getTitle(); ?>" class="img-fluid rounded mx-auto d-block">
        <p class="mt-4"><?php echo $news->getDescription(); ?></p>
        <?php if(isUserAndAdmin()) { ?>
            <a href="/news_article/update/<?php echo $news->getId() ?>">Rediģēt</a>
            <a href="/news_article/delete/<?php echo $news->getId() ?>" onclick="return confirm('Vai tiešām vēlaties dzēst šo ziņu no saraksta?')">Nodzēst</a>
        <?php } ?>
    </div>

<?php include BASE_DIR . 'footer.php' ?>