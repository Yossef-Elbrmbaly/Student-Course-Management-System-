<?php

namespace App\Controllers;

use App\Contracts\DepartmentRepositoryInterface;

class DepartmentController
{
    public function __construct(private DepartmentRepositoryInterface $departmentRepository)
    {
    }

    public function index()
    {
        $departments = $this->departmentRepository->getAll();
        require_once __DIR__ . '/../views/departments/index.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../views/departments/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $name = $_POST['name'] ?? '';

        if (!empty($name)) {
            $this->departmentRepository->create($name);

            $this->redirect();
        }
    }

    public function edit()
    {
        $id = (int) ($_GET['id'] ?? 0);

        $department = $this->departmentRepository->getById($id);

        if ($department) {
            require_once __DIR__ . '/../views/departments/edit.php';
            return;
        }

        $this->redirect();
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $name = $_POST['name'] ?? '';

        if ($id > 0 && !empty($name)) {
            $this->departmentRepository->update($id, $name);

            $this->redirect();
        }
    }

    public function delete()
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->departmentRepository->delete($id);
        }

        $this->redirect();
    }

    private function redirect()
    {
        header('Location: index.php?page=departments');
        exit;
    }
}
