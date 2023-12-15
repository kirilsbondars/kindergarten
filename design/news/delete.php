<?php
include BASE_DIR . 'header.php';
require_once CONTROLLERS_DIR . 'News.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $news = News::get_news_by_id($id);
    $news?->delete();
}

header('Location: /news');
exit();