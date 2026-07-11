<?php

namespace Models;

use PDO;

class Enrollment {
    public function __construct(private PDO $db) {}

    public function getStudentCourses(int $student_id): array {
        $query = "SELECT courses.* 
                FROM courses 
                JOIN course_student ON courses.id = course_student.course_id 
                WHERE course_student.student_id = :student_id";
                
        $stmt = $this->db->prepare($query);
        $stmt->execute(['student_id' => $student_id]);
        return $stmt->fetchAll();
    }

    public function getCourseStudents(int $course_id): array {
        $query = "SELECT students.* 
                FROM students 
                JOIN course_student ON students.id = course_student.student_id 
                WHERE course_student.course_id = :course_id";
                
        $stmt = $this->db->prepare($query);
        $stmt->execute(['course_id' => $course_id]);
        return $stmt->fetchAll();
    }

    public function enroll(int $student_id, int $course_id): bool {
        $checkQuery = "SELECT * FROM course_student WHERE student_id = :student_id AND course_id = :course_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->execute(['student_id' => $student_id, 'course_id' => $course_id]);
        
        if ($checkStmt->fetch()) {
            return false; 
        }

        $query = "INSERT INTO course_student (student_id, course_id) VALUES (:student_id, :course_id)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'student_id' => $student_id,
            'course_id'  => $course_id
        ]);
    }

    public function drop(int $student_id, int $course_id): bool {
        $query = "DELETE FROM course_student WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'student_id' => $student_id,
            'course_id'  => $course_id
        ]);
    }
}