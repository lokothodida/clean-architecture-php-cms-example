<?php

namespace spec\PageManagementSystem\UseCases;

use PageManagementSystem\UseCases\CreatePage;
use PageManagementSystem\UseCases\CreatePage\RequestModel;
use PageManagementSystem\UseCases\CreatePage\ResponseModel;
use PageManagementSystem\Entities\Page;
use PageManagementSystem\UseCases\Exceptions\SlugAlreadyTaken;
use PageManagementSystem\Infrastructure\InMemoryPageRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreatePageSpec extends ObjectBehavior
{
    /** @var PageRepository */
    private $repository;

    public function let()
    {
        $this->repository = new InMemoryPageRepository();
    }

    public function it_should_not_create_pages_for_slugs_that_are_in_use()
    {
        $page = Page::create('test-page', 'test page', 'test-page');
        $this->repository->save($page);

        $this->beConstructedWith($this->repository);
        $this->shouldThrow(SlugAlreadyTaken::class)->duringExecute(new RequestModel('test-page', 'test page', 'test-page'));
    }

    public function it_should_create_new_pages()
    {
        $this->beConstructedWith($this->repository);
        $this->execute(new RequestModel(
            'test-page',
            'test page',
            'test-page'
        ))->shouldBeLike(new ResponseModel('test-page'));
    }
}
