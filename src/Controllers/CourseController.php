<?php

namespace App\Controllers;

use App\Contracts\CourseRepositoryInterface;
use App\Core\BaseController;
use App\Core\Request;
use App\Middleware\CsrfMiddleware;

class CourseController extends BaseController
{
    public function __construct(
        private CourseRepositoryInterface $courseRepository
    ) {
    }

    public function index(): void
    {
        $this->view('courses/index', [
            'courses' => $this->courseRepository->getAll(),
        ]);
    }

    public function create(): void
    {
        $this->view('courses/create');
    }

    public function store(): void
    {
        CsrfMiddleware::handle();

        $this->courseRepository->create(
            Request::input('name'),
            Request::input('code')
        );

        $this->redirect();
    }

    public function edit(): void
    {
        $id = Request::queryInt('id');

        $this->view('courses/edit', [
            'course' => $this->courseRepository->getById($id),
        ]);
    }

    public function update(): void
    {
        CsrfMiddleware::handle();

        $this->courseRepository->update(
            Request::inputInt('id'),
            Request::input('name'),
            Request::input('code')
        );

        $this->redirect();
    }

    public function delete(): void
    {
        CsrfMiddleware::handle();

        $id = Request::inputInt('id');

        $this->courseRepository->delete($id);

        $this->redirect();
    }
}
