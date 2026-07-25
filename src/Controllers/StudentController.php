<?php

namespace App\Controllers;

use App\Contracts\DepartmentRepositoryInterface;
use App\Contracts\EnrollmentRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Core\Auth;
use App\Core\BaseController;
use App\Core\Request;
use App\Exceptions\UnauthorizedException;
use App\Middleware\CsrfMiddleware;


class StudentController extends BaseController
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository,
        private DepartmentRepositoryInterface $departmentRepository,
        private EnrollmentRepositoryInterface $enrollmentRepository,
        private UserRepositoryInterface $userRepository
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

        if (!Auth::isAdmin() && Auth::studentId() !== $id) {
            throw new UnauthorizedException(
                'You are not authorized to view this student.'
            );
        }

        $student = $this->studentRepository->getById($id);

        $this->view('students/show', [
            'student' => $student,
            'department' => $student['department_id']
                ? $this->departmentRepository->getById((int) $student['department_id'])
                : null,
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
        CsrfMiddleware::handle();

        $studentId = $this->studentRepository->create(
            Request::input('name'),
            Request::input('email'),
            Request::input('phone'),
            Request::inputInt('department_id')
        );

        $this->userRepository->create(
            $studentId,
            Request::input('email'),
            password_hash('123456', PASSWORD_DEFAULT),
            'user'
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
        CsrfMiddleware::handle();

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
        CsrfMiddleware::handle();
        
        $id = Request::inputInt('id');

        $this->studentRepository->delete($id);

        $this->redirect();
    }
}
