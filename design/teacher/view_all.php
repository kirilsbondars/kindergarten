<?php
require_once BASE_DIR . 'header.php';
require_once(CONTROLLERS_DIR . 'Teacher.php');
require_once CONTENT_DIR . 'functions.php';

$teachers = Teacher::get_all();
?>


<?php if(is_user_and_admin()) { ?>
    <div class="container w-50 d-flex justify-content-center align-items-center mb-3">
        <div class="row">
            <div class="col">
                <a href="/teacher/create" class="btn btn-primary" role="button" aria-pressed="true">Pievienot jaunu ziņu</a>
            </div>
        </div>
    </div>
<?php } ?>

    <div class="container">
        <div class="row">
            <?php if (empty($teachers)) { ?>
                <p class="text-center mt-3">Nav neviena pedadoga. :(</p>
            <?php } ?>

            <?php foreach ($teachers as $teacher): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="<?php echo $teacher->getPathToImage() ?>" alt="Teacher image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $teacher->getName() . ' ' . $teacher->getSurname() ?></h5>
                            <p class="card-text"><?php echo $teacher->getDescription() ?></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Age: <?php echo $teacher->getAge() ?></small>
                            <?php if(is_user_and_admin()) { ?>
                            <a href="/teacher/update/<?php echo $teacher->getId() ?>" class="btn btn-primary">Rediģēt</a>
                            <a href="/teacher/delete/<?php echo $teacher->getId() ?>" class="btn btn-danger">Nodzēst</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php require_once BASE_DIR . 'footer.php'; ?>