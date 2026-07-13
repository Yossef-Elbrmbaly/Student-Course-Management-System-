<?php
var_dump("Hello, World!");

require_once '../config/Database.php';

require_once '../models/Student.php';
require_once '../models/Department.php';
require_once '../models/Course.php';
require_once '../models/Enrollment.php';

require_once '../controllers/StudentController.php';
require_once '../controllers/DepartmentController.php';
require_once '../controllers/CourseController.php';
require_once '../controllers/EnrollmentController.php';

use Config\Database;
use Models\Student;
use Models\Department;
use Models\Course;
use Models\Enrollment;

use Controllers\StudentController;
use Controllers\DepartmentController;
use Controllers\CourseController;
use Controllers\EnrollmentController;

$database = new Database();

if ($database->checkConnection()) {
    die("Database connection problem: Database instance is null.");
}else {
    echo "Database connection false.";
}
$connection = $database->connect();

$page = $_GET['page'] ?? 'students';
$action = $_GET['action'] ?? 'index';

if ($page === 'departments') {

    $departmentModel = new Department($connection);
    $departmentController = new DepartmentController($departmentModel);

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
}else if ($page === 'courses') {

    $courseModel = new Course($connection);
    $courseController = new CourseController($courseModel);

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
}elseif ($page === 'enrollments') {

    $enrollmentModel = new Enrollment($connection);
    $studentModel = new Student($connection);
    $courseModel = new Course($connection);

    $enrollmentController = new EnrollmentController(
        $enrollmentModel,
        $studentModel,
        $courseModel
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

}else {
    $studentModel = new Student($connection);
    $departmentModel = new Department($connection);
    $enrollmentModel = new Enrollment($connection);


    $studentController = new StudentController(
        $studentModel,
        $departmentModel,
        $enrollmentModel
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
    }else {
        $studentController->index();
    }
}