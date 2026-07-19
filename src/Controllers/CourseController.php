<?php

namespace App\Controllers;

use App\Contracts\CourseRepositoryInterface;
use App\Core\BaseController;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;

class CourseController extends BaseController
{
    public function __construct(
        private CourseRepositoryInterface $courseRepository
    ) {
    }

    public function index(): void
    {
        $courses = $this->courseRepository->getAll();

        $this->view('courses/index', [
            'courses' => $courses,
        ]);
    }

    public function create(): void
    {
        $this->view('courses/create');
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $code = trim($_POST['code'] ?? '');

        if (empty($name) || empty($code)) {
            throw new ValidationException(
                'Course name and code are required.'
            );
        }

        $this->courseRepository->create($name, $code);

        $this->redirect();
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $course = $this->courseRepository->getById($id);

        if (!$course) {
            throw new NotFoundException(
                'Course not found.'
            );
        }

        $this->view('courses/edit', [
            'course' => $course,
        ]);
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $code = trim($_POST['code'] ?? '');

        if ($id <= 0 || empty($name) || empty($code)) {
            throw new ValidationException(
                'Invalid course data.'
            );
        }

        $this->courseRepository->update($id, $name, $code);

        $this->redirect();
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            throw new ValidationException(
                'Invalid course id.'
            );
        }

        $this->courseRepository->delete($id);

        $this->redirect();
    }
}
