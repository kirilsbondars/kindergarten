<?php
require_once CONTROLLERS_DIR . 'Teacher.php';

$teacher_id = $_GET['id'];

$teacher = Teacher::getTeacherById($teacher_id);

if (!$teacher) {
    die('Teacher not found');
}

$title = $teacher->getFullName();
include(BASE_DIR . 'header.php');
?>

    <div class="container w-50 px-3">
        <h1 class="mx-auto text-center p-2"><?php echo $teacher->getFullName(); ?></h1>
        <img src="<?php echo $teacher->getPathToImage(); ?>" alt="<?php echo $teacher->getFullName(); ?>" class="img-fluid rounded mx-auto d-block">
        <p class="mt-4"><?php echo $teacher->getDescription(); ?></p>
        <p class="mt-4">Vecums: <?php echo $teacher->getAge(); ?></p>
        <?php if(isUserAndAdmin()) { ?>
            <a href="/teacher/update/<?php echo $teacher->getId() ?>">Rediģēt</a>
            <a href="/teacher/delete/<?php echo $teacher->getId() ?>" onclick="return confirm('Vai tiešām vēlaties dzēst šo pedadogu no saraksta?')">Nodzēst</a>
        <?php } ?>
    </div>

<?php include BASE_DIR . 'footer.php' ?>