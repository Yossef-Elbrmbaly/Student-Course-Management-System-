<?php

namespace App\Controllers;

use App\Contracts\CourseRepositoryInterface;
use App\Contracts\EnrollmentRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;
use App\Core\BaseController;
use App\Exceptions\ValidationException;

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
        $enrollments = $this->enrollmentRepository->getAll();

        $this->view('enrollments/index', [
            'enrollments' => $enrollments,
        ]);
    }

    public function create(): void
    {
        $students = $this->studentRepository->getAll();
        $courses = $this->courseRepository->getAll();

        $this->view('enrollments/create', [
            'students' => $students,
            'courses' => $courses,
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $student_id = (int) ($_POST['student_id'] ?? 0);
        $course_id = (int) ($_POST['course_id'] ?? 0);

        if ($student_id <= 0 || $course_id <= 0) {
            throw new ValidationException(
                'Student and Course are required.'
            );
        }

        $result = $this->enrollmentRepository->enroll(
            $student_id,
            $course_id
        );

        if (!$result) {
            throw new ValidationException(
                'Student is already enrolled in this course.'
            );
        }

        $this->redirect();
    }

    public function drop(): void
    {
        $student_id = (int) ($_GET['student_id'] ?? 0);
        $course_id = (int) ($_GET['course_id'] ?? 0);

        if ($student_id <= 0 || $course_id <= 0) {
            throw new ValidationException(
                'Invalid enrollment data.'
            );
        }

        $this->enrollmentRepository->drop(
            $student_id,
            $course_id
        );

        $this->redirect();
    }
}
