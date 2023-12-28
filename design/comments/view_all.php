<?php
global $current_user;
include(BASE_DIR . 'header.php');
require_once(CONTROLLERS_DIR . 'Comment.php');
require_once(CONTROLLERS_DIR . 'User.php');
require_once (CONTENT_DIR . 'functions.php');

$comments = Comment::getAll();
?>

    <div class="container">
    <div class="row">
        <div class="col text-center mb-3">
            <h1 class="mx-auto text-center">Viesu delis</h1>
            <?php if(isUserAuthorized()): ?>
                <a href="/comment/create" class="btn btn-primary" role="button">Pievienot jaunu komentāru</a>
            <?php else: ?>
                <p>Lai pievienotu komentāru, lūdzu, pieteikties sistēmā.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <?php if (empty($comments)) { ?>
            <p class="text-center mt-3">Nav neviena komentāra. :(</p>
        <?php } ?>

        <?php foreach ($comments as $comment): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <p class="card-text"><?php echo $comment->getText() ?></p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Izveidots: <?php echo $comment->getCreatedAt() ?></small><br>
                        <small class="text-muted">Autors: <?php echo $comment->getUserFullName() ?></small>
                        <?php if(isUserAndAdmin()): ?>
                            <br><a href="/comment/delete/<?php echo $comment->getId()?>" onclick="return confirm('Vai tiešām vēlaties dzēst šo komentāru?')">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


<?php include(BASE_DIR . 'footer.php'); ?>