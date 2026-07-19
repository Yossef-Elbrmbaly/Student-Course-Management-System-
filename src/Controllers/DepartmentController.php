<?php

namespace App\Controllers;

use App\Contracts\DepartmentRepositoryInterface;
use App\Core\BaseController;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;

class DepartmentController extends BaseController
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    ) {
    }

    public function index(): void
    {
        $departments = $this->departmentRepository->getAll();

        $this->view('departments/index', [
            'departments' => $departments,
        ]);
    }

    public function create(): void
    {
        $this->view('departments/create');
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $name = trim($_POST['name'] ?? '');

        if (empty($name)) {
            throw new ValidationException(
                'Department name is required.'
            );
        }

        $this->departmentRepository->create($name);

        $this->redirect();
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $department = $this->departmentRepository->getById($id);

        if (!$department) {
            throw new NotFoundException(
                'Department not found.'
            );
        }

        $this->view('departments/edit', [
            'department' => $department,
        ]);
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');

        if ($id <= 0 || empty($name)) {
            throw new ValidationException(
                'Invalid department data.'
            );
        }

        $this->departmentRepository->update($id, $name);

        $this->redirect();
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            throw new ValidationException(
                'Invalid department id.'
            );
        }

        $this->departmentRepository->delete($id);

        $this->redirect();
    }
}
