<?php

namespace PageManagementSystem\Plugins\ApiGateway\Http;

use PageManagementSystem\UseCases\UseCaseFactory;
use PageManagementSystem\UseCases\CreatePage\RequestModel as CreatePageRequestModel;
use PageManagementSystem\UseCases\UpdatePage\RequestModel as UpdatePageRequestModel;
use PageManagementSystem\UseCases\RenameSlug\RequestModel as RenameSlugRequestModel;
use PageManagementSystem\UseCases\DeletePage\RequestModel as DeletePageRequestModel;
use PageManagementSystem\Plugins\Database\ViewModel\PageRepository;
use PageManagementSystem\Plugins\Database\ViewModel\Page;

class PageController
{
    /** @var UseCaseFactory */
    private $useCases;

    /** @var PageRepository */
    private $pageViewRepository;

    public function __construct(UseCaseFactory $useCases, PageRepository $repository)
    {
        $this->useCases = $useCases;
        $this->repository = $repository;
    }

    public function viewPage(string $slug): JsonResponse
    {
        return new JsonResponse(200, [
            'data' => $this->pageToArray($this->repository->get($slug))
        ]);
    }

    private function pageToArray(Page $page): array
    {
        return [
            'slug' => $page->getSlug(),
            'title' => $page->getTitle(),
            'content' => $page->getContent()
        ];
    }

    public function viewAllPages(): JsonResponse
    {
        return new JsonResponse(200, [
            'data' => array_map(function(Page $page) {
                return $this->pageToArray($page);
            }, $this->repository->getAll())
        ]);
    }

    public function renameSlug(string $oldSlug, string $newSlug): JsonResponse
    {
        $responseModel = $this->useCases->renameSlug(new RenameSlugRequestModel($oldSlug, $newSlug));

        return new JsonResponse(200, [
            'data' => [
                'slug' => $responseModel->getSlug(),
            ]
        ]);
    }

    public function createPage(string $title, string $content): JsonResponse
    {
        $responseModel = $this->useCases->createPage(new CreatePageRequestModel($title, $title, $content));

        return new JsonResponse(201, [
            'data' => [
                'slug' => $responseModel->getSlug(),
            ]
        ]);
    }

    public function updatePage(string $slug, string $title, string $content): JsonResponse
    {
        $responseModel = $this->useCases->updatePage(new UpdatePageRequestModel($slug, $title, $content));

        return new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]);
    }

    public function deletePage(string $slug): JsonResponse
    {
        $responseModel = $this->useCases->deletePage(new DeletePageRequestModel($slug));

        return new JsonResponse(200, [
            'data' => [
                'status' => 'Success',
            ]
        ]);
    }
}
