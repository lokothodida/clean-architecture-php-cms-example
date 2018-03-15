<?php

namespace PageManagementSystem\UseCases;

use PageManagementSystem\UseCases\UseCase;
use PageManagementSystem\UseCases\Exceptions\SlugAlreadyTaken;
use PageManagementSystem\Entities\Page;
use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\UseCases\CreatePage\RequestModel;
use PageManagementSystem\UseCases\CreatePage\ResponseModel;

class CreatePage implements UseCase
{
    /** @var PageRepository */
    private $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RequestModel $request): ResponseModel
    {
        $page = Page::create($request->getSlug(), $request->getTitle(), $request->getContent());

        if ($this->repository->exists($page->slug())) {
            throw new SlugAlreadyTaken($page->slug());
        }

        $this->repository->save($page);

        return new ResponseModel((string)$page->slug());
    }
}
