<?php

namespace App\Controllers;

use App\Contracts\CourseRepositoryInterface;
use App\Contracts\EnrollmentRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;
use App\Core\BaseController;
use App\Core\Request;
use App\Exceptions\InvalidMethodException;

class EnrollmentController extends BaseController
{
    public function __construct(
        private EnrollmentRepositoryInterface $enrollmentRepository,
        private StudentRepositoryInterface $studentRepository,
        private CourseRepositoryInterface $courseRepository
    ) {
    }

    public function index(): void
    {
        $this->view('enrollments/index', [
            'enrollments' => $this->enrollmentRepository->getAll(),
        ]);
    }

    public function create(): void
    {
        $this->view('enrollments/create', [
            'students' => $this->studentRepository->getAll(),
            'courses' => $this->courseRepository->getAll(),
        ]);
    }

    public function store(): void
    {
        if (Request::method() !== 'POST') {
            throw new InvalidMethodException('Only POST requests are allowed.');
        }

        $this->enrollmentRepository->enroll(
            Request::inputInt('student_id'),
            Request::inputInt('course_id')
        );

        $this->redirect();
    }

    public function drop(): void
    {
        $this->enrollmentRepository->drop(
            Request::queryInt('student_id'),
            Request::queryInt('course_id')
        );

        $this->redirect();
    }
}
