<?php

namespace PageManagementSystem\UseCases\UpdatePage;

use PageManagementSystem\UseCases\UseCase as UseCaseInterface;
use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\Entities\Page;
use PageManagementSystem\Entities\Slug;
use PageManagementSystem\Entities\Title;
use PageManagementSystem\Entities\Content;
use PageManagementSystem\Entities\Exceptions\PageDoesNotExist;
use PageManagementSystem\UseCases\UpdatePage\RequestModel;
use PageManagementSystem\UseCases\UpdatePage\ResponseModel;

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
        $slug = Slug::fromString($request->getSlug());

        if (!$this->repository->exists($slug)) {
            throw new PageDoesNotExist($slug);
        }

        $page = $this->repository->get($slug);
        $page->updateTitle(Title::fromString($request->getTitle()));
        $page->updateContent(Content::fromString($request->getContent()));

        $this->repository->save($page);

        return new ResponseModel();
    }
}
