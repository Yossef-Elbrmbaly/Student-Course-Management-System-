<?php

namespace App\Controllers;

use App\Contracts\CourseRepositoryInterface;

class CourseController
{
    public function __construct(private CourseRepositoryInterface $courseRepository)
    {
    }

    public function index()
    {
        $courses = $this->courseRepository->getAll();
        require_once __DIR__ . '/../views/courses/index.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../views/courses/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $code = $_POST['code'] ?? '';

            if (!empty($name) && !empty($code)) {
                $this->courseRepository->create($name, $code, $credits);
                $this->redirect();
            }
        }
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $course = $this->courseRepository->getById($id);
        if ($course) {
            require_once __DIR__ . '/../views/courses/edit.php';
        } else {
            $this->redirect();
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $name = $_POST['name'] ?? '';
            $code = $_POST['code'] ?? '';

            if ($id > 0 && !empty($name) && !empty($code)) {
                $this->courseRepository->update($id, $name, $code, $credits);
                $this->redirect();
            }
        }
    }

    public function delete()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $this->courseRepository->delete($id);
        }
        $this->redirect();
    }

    private function redirect()
    {
        header('Location: index.php?page=courses');
        exit;
    }
}
