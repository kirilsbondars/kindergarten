<?php
require_once CONTROLLERS_DIR . 'Teacher.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $teacher = Teacher::getTeacherById($id);

    if ($teacher) {
        $result = $teacher->delete();

        if ($result) {
            $_SESSION['success_message'] = 'Skolotājs "' . $teacher->getFullName() . '" tika izdzēsts no saraksta.';
        } else {
            $_SESSION['error_message'] = 'Kļūda, dzēšot skolotāju.';
        }
    } else {
        $_SESSION['error_message'] = 'Skolotājs nav atrasts.';
    }

    header('Location: /teachers');
    exit();
}