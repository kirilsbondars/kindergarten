<?php
require_once BASE_DIR . 'header.php';
require_once(CONTROLLERS_DIR . 'Teacher.php');
require_once CONTENT_DIR . 'functions.php';

$teachers = Teacher::getAll();
?>


<?php if(isUserAndAdmin()) { ?>
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
                            <?php if(isUserAndAdmin()) { ?>
                            <a href="/teacher/update/<?php echo $teacher->getId() ?>">Rediģēt</a>
                            <a href="/teacher/delete/<?php echo $teacher->getId() ?>" onclick="return confirm('Vai tiešām vēlaties dzēst šo pedadogu no saraksta?')">Nodzēst</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php require_once BASE_DIR . 'footer.php'; ?>