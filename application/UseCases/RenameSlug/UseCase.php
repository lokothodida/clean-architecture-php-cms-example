<?php

namespace PageManagementSystem\UseCases\RenameSlug;

use PageManagementSystem\UseCases\UseCase as UseCaseInterface;
use PageManagementSystem\Entities\Slug;
use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\UseCases\Exceptions\SlugAlreadyTaken;
use PageManagementSystem\UseCases\RenameSlug\RequestModel;
use PageManagementSystem\UseCases\RenameSlug\ResponseModel;

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
        $oldSlug = Slug::fromString($request->getOldSlug());
        $newSlug = Slug::fromString($request->getNewSlug());

        if ($this->repository->exists($newSlug)) {
            throw new SlugAlreadyTaken($newSlug);
        }

        $page = $this->repository->get($oldSlug);

        $this->repository->delete($page->slug());

        $page->renameSlug($newSlug);

        $this->repository->save($page);

        return new ResponseModel((string)$page->slug());
    }
}
