<?php

namespace spec\PageManagementSystem\UseCases\UpdatePage;

use PageManagementSystem\UseCases\UpdatePage;
use PageManagementSystem\Entities\Exceptions\PageDoesNotExist;
use PageManagementSystem\Entities\Page;
use PageManagementSystem\Entities\Slug;
use PageManagementSystem\Entities\Title;
use PageManagementSystem\Entities\Content;
use PageManagementSystem\Infrastructure\InMemoryPageRepository;
use PageManagementSystem\UseCases\UpdatePage\RequestModel;
use PageManagementSystem\UseCases\UpdatePage\ResponseModel;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UseCaseSpec extends ObjectBehavior
{
    /** @var PageRepository */
    private $repository;

    public function let()
    {
        $this->repository = new InMemoryPageRepository();
    }

    public function it_cannot_update_nonexistent_pages()
    {
        $this->beConstructedWith($this->repository);
        $this->shouldThrow(PageDoesNotExist::class)->duringExecute(new RequestModel('test-page', 'test', 'test2'));
    }

    public function it_updates_pages()
    {
        $this->repository->save(Page::create('test-page', 'lorem', 'ipsum'));

        $this->beConstructedWith($this->repository);

        $this->execute(new RequestModel('test-page', 'lorem2', 'ipsum3'))->shouldBeLike(new ResponseModel());
    }
}
