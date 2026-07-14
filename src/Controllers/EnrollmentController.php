<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Course;

class EnrollmentController
{
    public function __construct(
        private Enrollment $enrollmentModel,
        private Student $studentModel,
        private Course $courseModel
    ) {
    }

    public function index()
    {
        $enrollments = $this->enrollmentModel->getAll();

        require_once __DIR__ . '/../views/enrollments/index.php';
    }

    public function create()
    {
        $students = $this->studentModel->getAll();
        $courses = $this->courseModel->getAll();

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
            $this->enrollmentModel->enroll($student_id, $course_id);
        }

        $this->redirect();
    }

    public function drop()
    {
        $student_id = (int) ($_GET['student_id'] ?? 0);
        $course_id = (int) ($_GET['course_id'] ?? 0);

        if ($student_id > 0 && $course_id > 0) {
            $this->enrollmentModel->drop($student_id, $course_id);
        }

        $this->redirect();
    }

    private function redirect()
    {
        header('Location: index.php?page=enrollments');
        exit;
    }
}