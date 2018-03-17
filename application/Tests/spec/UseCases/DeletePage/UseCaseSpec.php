<?php

namespace spec\PageManagementSystem\UseCases\DeletePage;

use Exception;
use PageManagementSystem\UseCases\DeletePage;
use PageManagementSystem\Infrastructure\InMemoryPageRepository;
use PageManagementSystem\UseCases\DeletePage\RequestModel;
use PageManagementSystem\UseCases\DeletePage\ResponseModel;
use PageManagementSystem\Entities\Page;
use PhpSpec\ObjectBehavior;

class UseCaseSpec extends ObjectBehavior
{
    /** @var PageRepository */
    private $repository;

    public function let()
    {
        $this->repository = new InMemoryPageRepository();
    }

    public function it_should_delete_pages()
    {
        $page = Page::create('test-page', 'lorem', 'ipsum');
        $this->repository->save($page);
        $this->beConstructedWith($this->repository);
        $this->execute(new RequestModel('test-page'))->shouldBeLike(
            new ResponseModel()
        );
    }
}
