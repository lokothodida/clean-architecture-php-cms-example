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

use PageManagementSystem\Plugins\UserAuthorization\Entities\SessionRepository;

class PageController
{
    /** @var UseCaseFactory */
    private $useCases;

    /** @var PagePresenterRepository */
    private $repository;

    public function __construct(UseCaseFactory $useCases)
    {
        $this->useCases = $useCases;
    }

    public function renameSlug(Request $request, string $oldSlug): JsonResponse
    {
        if (!$this->sessionRepository->exists()) {
            return new JsonResponse(401, [
                'error' => [
                    'message' => 'Must be logged in'
                ]
            ]);
        }

        try {
            $responseModel = $this->useCases->renameSlug(
                $oldSlug,
                $request->input('slug')
            );

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
        if (!$this->sessionRepository->exists()) {
            return new JsonResponse(401, [
                'error' => [
                    'message' => 'Must be logged in'
                ]
            ]);
        }

        try {
            $responseModel = $this->useCases->createPage(
                $request->input('title'),
                $request->input('title'),
                $request->input('content')
            );

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
        if (!$this->sessionRepository->exists()) {
            return new JsonResponse(401, [
                'error' => [
                    'message' => 'Must be logged in'
                ]
            ]);
        }

        try {
            $responseModel = $this->useCases->updatePage(
                $slug,
                $request->input('title'),
                $request->input('content')
            );

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
        if (!$this->sessionRepository->exists()) {
            return new JsonResponse(401, [
                'error' => [
                    'message' => 'Must be logged in'
                ]
            ]);
        }

        try {
            $responseModel = $this->useCases->deletePage($slug);

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
