<?php

namespace PageManagementSystem\UseCases\CreatePage;

use PageManagementSystem\UseCases\UseCase as UseCaseInterface;
use PageManagementSystem\UseCases\Exceptions\SlugAlreadyTaken;
use PageManagementSystem\Entities\Page;
use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\UseCases\CreatePage\RequestModel;
use PageManagementSystem\UseCases\CreatePage\ResponseModel;

class UseCase implements UseCaseInterface
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
