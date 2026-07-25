<?php

namespace App\Controllers;

use App\Contracts\DepartmentRepositoryInterface;
use App\Core\BaseController;
use App\Core\Request;
use App\Middleware\CsrfMiddleware;

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
        CsrfMiddleware::handle();

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
        CsrfMiddleware::handle();

        $this->departmentRepository->update(
            Request::inputInt('id'),
            Request::input('name')
        );

        $this->redirect();
    }

    public function delete(): void
    {
        CsrfMiddleware::handle();

        $id = Request::inputInt('id');

        $this->departmentRepository->delete($id);

        $this->redirect();
    }
}
