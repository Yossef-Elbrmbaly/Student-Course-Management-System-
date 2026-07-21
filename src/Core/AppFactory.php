<?php

namespace App\Core;

use App\Controllers\CourseController;
use App\Controllers\DepartmentController;
use App\Controllers\EnrollmentController;
use App\Controllers\StudentController;
use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\StudentRepository;
use PDO;

class AppFactory
{
    public static function studentController(PDO $connection): StudentController
    {
        return new StudentController(
            new StudentRepository($connection),
            new DepartmentRepository($connection),
            new EnrollmentRepository($connection)
        );
    }

    public static function departmentController(PDO $connection): DepartmentController
    {
        return new DepartmentController(
            new DepartmentRepository($connection)
        );
    }

    public static function courseController(PDO $connection): CourseController
    {
        return new CourseController(
            new CourseRepository($connection)
        );
    }

    public static function enrollmentController(PDO $connection): EnrollmentController
    {
        return new EnrollmentController(
            new EnrollmentRepository($connection),
            new StudentRepository($connection),
            new CourseRepository($connection)
        );
    }
}
