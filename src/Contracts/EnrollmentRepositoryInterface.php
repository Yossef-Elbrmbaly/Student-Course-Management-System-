<?php

namespace App\Contracts;

interface EnrollmentRepositoryInterface
{
    public function getAll(): array;

    public function getStudentCourses(int $student_id): array;

    public function getCourseStudents(int $course_id): array;

    public function enroll(int $student_id, int $course_id): bool;

    public function drop(int $student_id, int $course_id): bool;
}
