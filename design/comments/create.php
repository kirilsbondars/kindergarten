<?php
require_once CONTROLLERS_DIR . 'Comment.php';

global $current_user;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = htmlspecialchars($_POST['text']);

    $comment = Comment::createComment($text, $current_user->getId());

    try {
        $comment->create();
        $_SESSION['success_message'] = 'Jauns komentārs tika izveidots.';
        header('Location: /comments');
        exit();
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: /comments');
        exit();
    }
}

$title = 'Izveidot jaunu komentāru';
include(BASE_DIR . 'header.php');
?>

    <div class="container w-50 p-3">
        <h1 class="mx-auto text-center p-2">Izveidot jaunu komentāru</h1>
        <form method="POST">
            <div class="form-group mb-2">
                <label for="text">Komentārs:</label>
                <textarea class="form-control" id="text" name="text" rows="10" maxlength="255" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary mx-auto d-block mt-4">Izveidot</button>
        </form>
    </div>

<?php include BASE_DIR . 'footer.php' ?>