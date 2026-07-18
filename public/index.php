<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

use App\Config\Database;
use App\Controllers\CourseController;
use App\Controllers\DepartmentController;
use App\Controllers\EnrollmentController;
use App\Controllers\StudentController;
use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\StudentRepository;

$database = new Database();

$connection = $database->connect();

$page = $_GET['page'] ?? 'students';
$action = $_GET['action'] ?? 'index';

if ($page === 'departments') {

    $departmentRepository = new DepartmentRepository($connection);
    $departmentController = new DepartmentController($departmentRepository);

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

    $courseRepository = new CourseRepository($connection);
    $courseController = new CourseController($courseRepository);

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

    $enrollmentRepository = new EnrollmentRepository($connection);
    $studentRepository = new StudentRepository($connection);
    $courseRepository = new CourseRepository($connection);

    $enrollmentController = new EnrollmentController(
        $enrollmentRepository,
        $studentRepository,
        $courseRepository
    );

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
    $studentRepository = new StudentRepository($connection);
    $departmentRepository = new DepartmentRepository($connection);
    $enrollmentRepository = new EnrollmentRepository($connection);


    $studentController = new StudentController(
        $studentRepository,
        $departmentRepository,
        $enrollmentRepository
    );

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
