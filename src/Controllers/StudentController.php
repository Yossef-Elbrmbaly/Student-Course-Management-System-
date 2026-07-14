<?php

namespace App\Controllers;

use App\Contracts\DepartmentRepositoryInterface;
use App\Contracts\EnrollmentRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;

class StudentController
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository,
        private DepartmentRepositoryInterface $departmentRepository,
        private EnrollmentRepositoryInterface $enrollmentRepository
    ) {
    }

    public function index()
    {
        $students = $this->studentRepository->getAll();

        require_once __DIR__ . '/../views/students/index.php';
    }

    public function show()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $student = $this->studentRepository->getById($id);

        if (!$student) {
            $this->redirect();
        }

        $department = null;
        if (!empty($student['department_id'])) {
            $department = $this->departmentRepository->getById((int) $student['department_id']);
        }

        $courses = $this->enrollmentRepository->getStudentCourses($id);

        require_once __DIR__ . '/../views/students/show.php';
    }

    public function create()
    {
        $departments = $this->departmentRepository->getAll();

        require_once __DIR__ . '/../views/students/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $department_id = (int) ($_POST['department_id'] ?? 0);

        if (empty($name) || empty($email)) {
            echo 'Name and Email are required fields.';
            return;
        }

        $this->studentModel->create($name, $email, $phone, $department_id);

        $this->redirect();
    }

    public function edit()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $student = $this->studentRepository->getById($id);

        if (!$student) {
            $this->redirect();
        }

        $departments = $this->departmentRepository->getAll();

        require_once __DIR__ . '/../views/students/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $department_id = (int) ($_POST['department_id'] ?? 0);

        if ($id <= 0 || empty($name) || empty($email)) {
            echo 'Invalid data provided.';
            return;
        }

        $this->studentModel->update($id, $name, $email, $phone, $department_id);

        $this->redirect();
    }

    public function delete()
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->studentRepository->delete($id);
        }

        $this->redirect();
    }

    private function redirect()
    {
        header('Location: index.php');
        exit;
    }
}
