<?php

namespace App\Controllers;

use App\Contracts\DepartmentRepositoryInterface;
use App\Core\BaseController;
use App\Core\Request;
use App\Exceptions\InvalidMethodException;

class DepartmentController extends BaseController
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    ) {
    }

    public function index(): void
    {
        $this->view('departments/index', [
            'departments' => $this->departmentRepository->getAll(),
        ]);
    }

    public function create(): void
    {
        $this->view('departments/create');
    }

    public function store(): void
    {
        if (Request::method() !== 'POST') {
            throw new InvalidMethodException('Only POST requests are allowed.');
        }

        $this->departmentRepository->create(
            Request::input('name')
        );

        $this->redirect();
    }

    public function edit(): void
    {
        $id = Request::queryInt('id');

        $this->view('departments/edit', [
            'department' => $this->departmentRepository->getById($id),
        ]);
    }

    public function update(): void
    {
        if (Request::method() !== 'POST') {
            throw new InvalidMethodException('Only POST requests are allowed.');
        }

        $this->departmentRepository->update(
            Request::inputInt('id'),
            Request::input('name')
        );

        $this->redirect();
    }

    public function delete(): void
    {
        $id = Request::queryInt('id');

        $this->departmentRepository->delete($id);

        $this->redirect();
    }
}
