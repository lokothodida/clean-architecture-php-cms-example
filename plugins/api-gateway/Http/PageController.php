<?php

namespace PageManagementSystem\Plugins\ApiGateway\Http;

use Exception;
use PageManagementSystem\UseCases\UseCaseFactory;
use PageManagementSystem\UseCases\CreatePage\RequestModel as CreatePageRequestModel;
use PageManagementSystem\UseCases\UpdatePage\RequestModel as UpdatePageRequestModel;
use PageManagementSystem\UseCases\RenameSlug\RequestModel as RenameSlugRequestModel;
use PageManagementSystem\UseCases\DeletePage\RequestModel as DeletePageRequestModel;
use PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository;
use PageManagementSystem\Plugins\Database\ViewModel\Page;

class PageController
{
    /** @var UseCaseFactory */
    private $useCases;

    /** @var PagePresenterRepository */
    private $repository;

    public function __construct(UseCaseFactory $useCases, PagePresenterRepository $repository)
    {
        $this->useCases = $useCases;
        $this->repository = $repository;
    }

    public function viewPage(Request $request, string $slug): JsonResponse
    {
        try {
            return new JsonResponse(200, [
                'data' => $this->pageToArray($this->repository->get($slug))
            ]);
        } catch (Exception $exception) {
            return new JsonResponse(404, [
                'data' => [
                    'error' => sprintf('Cannot find page "%s".', $slug),
                ]
            ]);
            ;
        }
    }

    public function viewAllPages(Request $request): JsonResponse
    {
        try {
            return new JsonResponse(200, [
                'data' => array_map([$this, 'pageToArray'], $this->repository->getAll())
            ]);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    private function pageToArray(Page $page): array
    {
        return [
            'slug' => $page->getSlug(),
            'title' => $page->getTitle(),
            'content' => $page->getContent()
        ];
    }

    public function renameSlug(Request $request, string $oldSlug): JsonResponse
    {
        try {
            $responseModel = $this->useCases->renameSlug(new RenameSlugRequestModel(
                $oldSlug,
                $request->input('slug')
            ));

            return new JsonResponse(200, [
                'data' => [
                    'slug' => $responseModel->getSlug(),
                ]
            ]);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    public function createPage(Request $request): JsonResponse
    {
        try {
            $responseModel = $this->useCases->createPage(new CreatePageRequestModel(
                $request->input('title'),
                $request->input('title'),
                $request->input('content')
            ));

            return new JsonResponse(201, [
                'data' => [
                    'slug' => $responseModel->getSlug(),
                ]
            ]);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    public function updatePage(Request $request, string $slug): JsonResponse
    {
        try {
            $responseModel = $this->useCases->updatePage(new UpdatePageRequestModel(
                $slug,
                $request->input('title'),
                $request->input('content')
            ));

            return new JsonResponse(200, [
                'data' => [
                    'status' => 'Success',
                ]
            ]);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    public function deletePage(Request $request, string $slug): JsonResponse
    {
        try {
            $responseModel = $this->useCases->deletePage(new DeletePageRequestModel($slug));

            return new JsonResponse(200, [
                'data' => [
                    'status' => 'Success',
                ]
            ]);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    private function error(Exception $exception)
    {
        return new JsonResponse(500, [
            'error' => [
                'message' => $exception->getMessage(),
            ]
        ]);
    }
}
