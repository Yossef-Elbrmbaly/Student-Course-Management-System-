<?php

namespace App\Controllers;

use App\Contracts\CourseRepositoryInterface;
use App\Contracts\EnrollmentRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;

class EnrollmentController
{
    public function __construct(
        private EnrollmentRepositoryInterface $enrollmentRepository,
        private StudentRepositoryInterface $studentRepository,
        private CourseRepositoryInterface $courseRepository
    ) {
    }

    public function index()
    {
        $enrollments = $this->enrollmentRepository->getAll();

        require_once __DIR__ . '/../views/enrollments/index.php';
    }

    public function create()
    {
        $students = $this->studentRepository->getAll();
        $courses = $this->courseRepository->getAll();

        require_once __DIR__ . '/../views/enrollments/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $student_id = (int) ($_POST['student_id'] ?? 0);
        $course_id = (int) ($_POST['course_id'] ?? 0);

        if ($student_id > 0 && $course_id > 0) {
            $this->enrollmentRepository->enroll($student_id, $course_id);
        }

        $this->redirect();
    }

    public function drop()
    {
        $student_id = (int) ($_GET['student_id'] ?? 0);
        $course_id = (int) ($_GET['course_id'] ?? 0);

        if ($student_id > 0 && $course_id > 0) {
            $this->enrollmentRepository->drop($student_id, $course_id);
        }

        $this->redirect();
    }

    private function redirect()
    {
        header('Location: index.php?page=enrollments');
        exit;
    }
}
