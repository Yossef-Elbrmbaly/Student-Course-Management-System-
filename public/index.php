<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

use App\Config\Database;
use App\Config\DatabaseConfig;
use App\Core\AppFactory;
use App\Core\ExceptionHandler;

set_exception_handler([ExceptionHandler::class, 'handle']);

$config = new DatabaseConfig();

$database = new Database($config);

$connection = $database->connect();

$page = $_GET['page'] ?? 'students';
$action = $_GET['action'] ?? 'index';

if ($page === 'departments') {

    $departmentController = AppFactory::departmentController($connection);

    if ($action === 'create') {
        $departmentController->create();
    } elseif ($action === 'store') {
        $departmentController->store();
    } elseif ($action === 'edit') {
        $departmentController->edit();
    } elseif ($action === 'update') {
        $departmentController->update();
    } elseif ($action === 'delete') {
        $departmentController->delete();
    } else {
        $departmentController->index();
    }
} elseif ($page === 'courses') {

    $courseController = AppFactory::courseController($connection);

    if ($action === 'create') {
        $courseController->create();
    } elseif ($action === 'store') {
        $courseController->store();
    } elseif ($action === 'edit') {
        $courseController->edit();
    } elseif ($action === 'update') {
        $courseController->update();
    } elseif ($action === 'delete') {
        $courseController->delete();
    } else {
        $courseController->index();
    }
} elseif ($page === 'enrollments') {

    $enrollmentController = AppFactory::enrollmentController($connection);

    if ($action === 'create') {
        $enrollmentController->create();
    } elseif ($action === 'store') {
        $enrollmentController->store();
    } elseif ($action === 'drop') {
        $enrollmentController->drop();
    } else {
        $enrollmentController->index();
    }

} else {

    $studentController = AppFactory::studentController($connection);

    if ($action === 'create') {
        $studentController->create();
    } elseif ($action === 'store') {
        $studentController->store();
    } elseif ($action === 'edit') {
        $studentController->edit();
    } elseif ($action === 'update') {
        $studentController->update();
    } elseif ($action === 'delete') {
        $studentController->delete();
    } elseif ($action === 'show') {
        $studentController->show();
    } else {
        $studentController->index();
    }
}
