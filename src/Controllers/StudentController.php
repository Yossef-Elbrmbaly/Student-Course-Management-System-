<?php

namespace App\Controllers;

use App\Contracts\DepartmentRepositoryInterface;
use App\Contracts\EnrollmentRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;
use App\Core\BaseController;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;

class StudentController extends BaseController
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository,
        private DepartmentRepositoryInterface $departmentRepository,
        private EnrollmentRepositoryInterface $enrollmentRepository
    ) {
    }

    public function index(): void
    {
        $students = $this->studentRepository->getAll();

        $this->view('students/index', [
            'students' => $students,
        ]);
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $student = $this->studentRepository->getById($id);

        if (!$student) {
            throw new NotFoundException('Student not found.');
        }

        $department = null;

        if (!empty($student['department_id'])) {
            $department = $this->departmentRepository->getById(
                (int) $student['department_id']
            );
        }

        $courses = $this->enrollmentRepository->getStudentCourses($id);

        $this->view('students/show', [
            'student' => $student,
            'department' => $department,
            'courses' => $courses,
        ]);
    }

    public function create(): void
    {
        $departments = $this->departmentRepository->getAll();

        $this->view('students/create', [
            'departments' => $departments,
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $department_id = (int) ($_POST['department_id'] ?? 0);

        if (empty($name) || empty($email)) {
            throw new ValidationException(
                'Name and Email are required.'
            );
        }

        $this->studentRepository->create(
            $name,
            $email,
            $phone,
            $department_id
        );

        $this->redirect();
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $student = $this->studentRepository->getById($id);

        if (!$student) {
            throw new NotFoundException('Student not found.');
        }

        $departments = $this->departmentRepository->getAll();

        $this->view('students/edit', [
            'student' => $student,
            'departments' => $departments,
        ]);
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $department_id = (int) ($_POST['department_id'] ?? 0);

        if ($id <= 0 || empty($name) || empty($email)) {
            throw new ValidationException(
                'Invalid data provided.'
            );
        }

        $this->studentRepository->update(
            $id,
            $name,
            $email,
            $phone,
            $department_id
        );

        $this->redirect();
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->studentRepository->delete($id);
        }

        $this->redirect();
    }
}
