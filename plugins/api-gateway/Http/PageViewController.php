<?php

namespace PageManagementSystem\Plugins\ApiGateway\Http;

use Exception;
use PageManagementSystem\Plugins\Database\Adapters\PagePresenterRepository;
use PageManagementSystem\Plugins\Database\ViewModel\Page;

class PageViewController
{
    /** @var PagePresenterRepository */
    private $repository;

    public function __construct(PagePresenterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function viewPage(Request $request, string $slug): JsonResponse
    {
        try {
            $page = $this->repository->get($slug);

            return new JsonResponse(200, [
                'data' => [
                    'slug' => $page->getSlug(),
                    'title' => $page->getTitle(),
                    'content' => $page->getContent()
                ]
            ]);
        } catch (Exception $exception) {
            return new JsonResponse(404, [
                'data' => [
                    'error' => sprintf('Cannot find page "%s".', $slug),
                ]
            ]);
        }
    }

    public function viewAllPages(Request $request): JsonResponse
    {
        try {
            return new JsonResponse(200, [
                'data' => array_map(function (Page $page) {
                    return [
                        'slug' => $page->getSlug(),
                        'title' => $page->getTitle()
                    ];
                }, $this->repository->getAll())
            ]);
        } catch (Exception $exception) {
            var_dump($exception);
            return $this->error($exception);
        }
    }

    private function error(Exception $exception): JsonResponse
    {
        return new JsonResponse(500, [
            'error' => [
                'message' => $exception->getMessage(),
            ]
        ]);
    }
}
