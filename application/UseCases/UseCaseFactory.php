<?php

namespace PageManagementSystem\UseCases;

use PageManagementSystem\Entities\PageRepository;
use PageManagementSystem\UseCases\CreatePage\UseCase as CreatePageUseCase;
use PageManagementSystem\UseCases\CreatePage\RequestModel as CreatePageRequestModel;
use PageManagementSystem\UseCases\CreatePage\ResponseModel as CreatePageResponseModel;
use PageManagementSystem\UseCases\UpdatePage\UseCase as UpdatePageUseCase;
use PageManagementSystem\UseCases\UpdatePage\RequestModel as UpdatePageRequestModel;
use PageManagementSystem\UseCases\UpdatePage\ResponseModel as UpdatePageResponseModel;
use PageManagementSystem\UseCases\RenameSlug\UseCase as RenameSlugUseCase;
use PageManagementSystem\UseCases\RenameSlug\RequestModel as RenameSlugRequestModel;
use PageManagementSystem\UseCases\RenameSlug\ResponseModel as RenameSlugResponseModel;
use PageManagementSystem\UseCases\DeletePage\UseCase as DeletePageUseCase;
use PageManagementSystem\UseCases\DeletePage\RequestModel as DeletePageRequestModel;
use PageManagementSystem\UseCases\DeletePage\ResponseModel as DeletePageResponseModel;

class UseCaseFactory
{
    private $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createPage(string $title, string $slug, string $content): CreatePageResponseModel
    {
        return (new CreatePageUseCase($this->repository))->execute(new CreatePageRequestModel($title, $slug, $content));
    }

    public function updatePage(string $title, string $slug, string $content): UpdatePageResponseModel
    {
        return (new UpdatePageUseCase($this->repository))->execute(new UpdatePageRequestModel($title, $slug, $content));
    }

    public function renameSlug(string $oldSlug, string $newSlug): RenameSlugResponseModel
    {
        return (new RenameSlugUseCase($this->repository))->execute(new RenameSlugRequestModel($oldSlug, $newSlug));
    }

    public function deletePage(string $slug): DeletePageResponseModel
    {
        return (new DeletePageUseCase($this->repository))->execute(new DeletePageRequestModel($slug));
    }
}
