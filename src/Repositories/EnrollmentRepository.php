<?php

namespace App\Repositories;

use App\Contracts\EnrollmentRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use PDO;
use PDOException;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function __construct(private PDO $connection)
    {
    }

    public function getAll(): array
    {
        $query = 'SELECT
                    students.id AS student_id,
                    students.name AS student_name,
                    courses.id AS course_id,
                    courses.name AS course_name,
                    courses.code
                FROM course_student
                INNER JOIN students ON course_student.student_id = students.id
                INNER JOIN courses ON course_student.course_id = courses.id
                ORDER BY students.name';

        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getStudentCourses(int $student_id): array
    {
        if ($student_id <= 0) {
            throw new ValidationException('Invalid student ID provided.');
        }

        $query = 'SELECT courses.* 
                FROM courses 
                JOIN course_student ON courses.id = course_student.course_id 
                WHERE course_student.student_id = :student_id';

        $stmt = $this->connection->prepare($query);
        $stmt->execute(['student_id' => $student_id]);

        return $stmt->fetchAll();
    }

    public function getCourseStudents(int $course_id): array
    {
        if ($course_id <= 0) {
            throw new ValidationException('Invalid course ID provided.');
        }

        $query = 'SELECT students.* 
                FROM students 
                JOIN course_student ON students.id = course_student.student_id 
                WHERE course_student.course_id = :course_id';

        $stmt = $this->connection->prepare($query);
        $stmt->execute(['course_id' => $course_id]);

        return $stmt->fetchAll();
    }

    public function enroll(int $student_id, int $course_id): bool
    {
        if ($student_id <= 0 || $course_id <= 0) {
            throw new ValidationException('Student and Course are required.');
        }

        $checkQuery = 'SELECT 1 FROM course_student 
                    WHERE student_id = :student_id AND course_id = :course_id';

        $checkStmt = $this->connection->prepare($checkQuery);
        $checkStmt->execute([
            'student_id' => $student_id,
            'course_id' => $course_id,
        ]);

        if ($checkStmt->fetch()) {
            throw new ValidationException('Student is already enrolled in this course.');
        }

        try {
            $query = 'INSERT INTO course_student (student_id, course_id) 
                    VALUES (:student_id, :course_id)';

            $stmt = $this->connection->prepare($query);

            return $stmt->execute([
                'student_id' => $student_id,
                'course_id' => $course_id,
            ]);

        } catch (PDOException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1062) {
                throw new ValidationException('Student is already enrolled in this course.');
            }

            if ($errorCode === 1452) {
                throw new ValidationException('The selected Student or Course does not exist.');
            }

            throw $e;
        }
    }

    public function drop(int $student_id, int $course_id): bool
    {
        if ($student_id <= 0 || $course_id <= 0) {
            throw new ValidationException('Invalid enrollment data provided.');
        }

        $checkQuery = 'SELECT 1 FROM course_student 
                    WHERE student_id = :student_id AND course_id = :course_id';

        $checkStmt = $this->connection->prepare($checkQuery);
        $checkStmt->execute([
            'student_id' => $student_id,
            'course_id' => $course_id,
        ]);

        if (!$checkStmt->fetch()) {
            throw new NotFoundException('This enrollment record does not exist.');
        }

        $query = 'DELETE FROM course_student 
                WHERE student_id = :student_id AND course_id = :course_id';

        $stmt = $this->connection->prepare($query);

        return $stmt->execute([
            'student_id' => $student_id,
            'course_id' => $course_id,
        ]);
    }
}
