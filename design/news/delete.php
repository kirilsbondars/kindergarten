<?php
#TODO: translate to Latvian
include BASE_DIR . 'header.php';
require_once CONTROLLERS_DIR . 'News.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $news = News::get_news_by_id($id);
    if ($news) {
        if ($news->delete()) {
            $_SESSION['success_message'] = 'Ziņa "' . $news->getTitle() . '" tika veiksmīgi izdzēsta.';
            header('Location: /news');
            exit();
        } else {
            echo 'Kļūda, dzēšot ziņu.';
        }
    } else {
        echo 'Ziņa ar id "' . $id . '" netika atrasta.';
    }
} else {
    echo 'Nav norādīts id.';
}