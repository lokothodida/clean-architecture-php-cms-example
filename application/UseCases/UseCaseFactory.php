<?php

namespace PageManagementSystem\UseCases;

use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\UseCases\CreatePage as CreatePageUseCase;
use PageManagementSystem\UseCases\CreatePage\RequestModel as CreatePageRequestModel;
use PageManagementSystem\UseCases\CreatePage\ResponseModel as CreatePageResponseModel;
use PageManagementSystem\UseCases\UpdatePage as UpdatePageUseCase;
use PageManagementSystem\UseCases\UpdatePage\RequestModel as UpdatePageRequestModel;
use PageManagementSystem\UseCases\UpdatePage\ResponseModel as UpdatePageResponseModel;
use PageManagementSystem\UseCases\RenameSlug as RenameSlugUseCase;
use PageManagementSystem\UseCases\RenameSlug\RequestModel as RenameSlugRequestModel;
use PageManagementSystem\UseCases\RenameSlug\ResponseModel as RenameSlugResponseModel;
use PageManagementSystem\UseCases\DeletePage as DeletePageUseCase;
use PageManagementSystem\UseCases\DeletePage\RequestModel as DeletePageRequestModel;
use PageManagementSystem\UseCases\DeletePage\ResponseModel as DeletePageResponseModel;

class UseCaseFactory
{
    private $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createPage(CreatePageRequestModel $request): CreatePageResponseModel
    {
        return (new CreatePageUseCase($this->repository))->$useCase->execute($request);
    }

    public function updatePage(UpdatePageRequestModel $request): UpdatePageResponseModel
    {
        return (new UpdatePageUseCase($this->repository))->execute($request);
    }

    public function renameSlug(RenameSlugRequestModel $request): RenameSlugResponseModel
    {
        return (new RenameSlugUseCase($this->repository))->execute($request);
    }

    public function deletePage(DeletePageRequestModel $request): DeletePageResponseModel
    {
        return (new DeletePageUseCase($this->repository))->execute($request);
    }
}
