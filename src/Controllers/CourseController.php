<?php

namespace App\Controllers;

use App\Contracts\CourseRepositoryInterface;
use App\Core\BaseController;
use App\Core\Request;
use App\Exceptions\InvalidMethodException;

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
        if (Request::method() !== 'POST') {
            throw new InvalidMethodException('Only POST requests are allowed.');
        }

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
        if (Request::method() !== 'POST') {
            throw new InvalidMethodException('Only POST requests are allowed.');
        }

        $this->courseRepository->update(
            Request::inputInt('id'),
            Request::input('name'),
            Request::input('code')
        );

        $this->redirect();
    }

    public function delete(): void
    {
        $id = Request::queryInt('id');

        $this->courseRepository->delete($id);

        $this->redirect();
    }
}
