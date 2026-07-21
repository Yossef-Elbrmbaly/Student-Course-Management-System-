<?php

namespace App\Controllers;

use App\Contracts\DepartmentRepositoryInterface;
use App\Contracts\EnrollmentRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;
use App\Core\BaseController;
use App\Core\Request;
use App\Exceptions\InvalidMethodException;

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
        $this->view('students/index', [
            'students' => $this->studentRepository->getAll(),
        ]);
    }

    public function show(): void
    {
        $id = Request::queryInt('id');

        $student = $this->studentRepository->getById($id);

        $this->view('students/show', [
            'student' => $student,
            'department' => $student['department_id'] ? $this->departmentRepository->getById((int) $student['department_id']) : null,
            'courses' => $this->enrollmentRepository->getStudentCourses($id),
        ]);
    }

    public function create(): void
    {
        $this->view('students/create', [
            'departments' => $this->departmentRepository->getAll(),
        ]);
    }

    public function store(): void
    {
        if (Request::method() !== 'POST') {
            throw new InvalidMethodException('Only POST requests are allowed.');
        }

        $this->studentRepository->create(
            Request::input('name'),
            Request::input('email'),
            Request::input('phone'),
            Request::inputInt('department_id')
        );

        $this->redirect();
    }

    public function edit(): void
    {
        $id = Request::queryInt('id');

        $this->view('students/edit', [
            'student' => $this->studentRepository->getById($id),
            'departments' => $this->departmentRepository->getAll(),
        ]);
    }

    public function update(): void
    {
        if (Request::method() !== 'POST') {
            throw new InvalidMethodException('Only POST requests are allowed.');
        }
        $this->studentRepository->update(
            Request::inputInt('id'),
            Request::input('name'),
            Request::input('email'),
            Request::input('phone'),
            Request::inputInt('department_id')
        );

        $this->redirect();
    }

    public function delete(): void
    {
        $id = Request::queryInt('id');

        $this->studentRepository->delete($id);

        $this->redirect();
    }
}
