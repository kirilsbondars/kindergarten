<?php
require_once CONTROLLERS_DIR . "Comment.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $comment = Comment::getCommentById($id);

    if ($comment) {
        $result = $comment->delete();

        if ($result) {
            $_SESSION['success_message'] = "Komentārs tika izdzēsts.";
        } else {
            $_SESSION['error_message'] = "Kļūda, dzēšot komentāru.";
        }
    } else {
        $_SESSION['error_message'] = "Komentārs netika atrasts.";
    }

    header("Location: /comments");
    exit();
}