<?php

namespace controllers;

use models\Department;

class DepartmentController {
    public function __construct(private Department $departmentModel) {}

    public function index() {
        $departments = $this->departmentModel->getAll();
        require_once '../views/departments/index.php';
    }

    public function create() {
        require_once '../views/departments/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $name = $_POST['name'] ?? '';

        if (!empty($name)) {
            $this->departmentModel->create($name);

            $this->redirect();
        }
    }

    public function edit() {
        $id = (int) ($_GET['id'] ?? 0);

        $department = $this->departmentModel->getById($id);

        if ($department) {
            require_once '../views/departments/edit.php';
            return;
        }

        $this->redirect();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $name = $_POST['name'] ?? '';

        if ($id > 0 && !empty($name)) {
            $this->departmentModel->update($id, $name);

            $this->redirect();
        }
    }

    public function delete() {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->departmentModel->delete($id);
        }

        $this->redirect();
    }

    private function redirect() {
        header('Location: index.php?page=departments');
        exit;
    }
}