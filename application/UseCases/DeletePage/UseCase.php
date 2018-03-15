<?php

namespace PageManagementSystem\UseCases\DeletePage;

use PageManagementSystem\UseCases\UseCase as UseCaseInterface;
use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\Entities\Slug;
use PageManagementSystem\UseCases\DeletePage\RequestModel;
use PageManagementSystem\UseCases\DeletePage\ResponseModel;

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
        $this->repository->delete(Slug::fromString($request->getSlug()));

        return new ResponseModel();
    }
}
