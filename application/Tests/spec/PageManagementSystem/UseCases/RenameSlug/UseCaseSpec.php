<?php

namespace spec\PageManagementSystem\UseCases\RenameSlug;

use Exception;
use PageManagementSystem\UseCases\RenameSlug;
use PageManagementSystem\Entities\Exceptions\PageDoesNotExist;
use PageManagementSystem\Entities\Page;
use PageManagementSystem\Entities\Slug;
use PageManagementSystem\Infrastructure\InMemoryPageRepository;
use PageManagementSystem\UseCases\Exceptions\SlugAlreadyTaken;
use PageManagementSystem\UseCases\RenameSlug\RequestModel;
use PageManagementSystem\UseCases\RenameSlug\ResponseModel;
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

    public function it_should_not_rename_non_existent_pages()
    {
        $this->beConstructedWith($this->repository);
        $this->shouldThrow(PageDoesNotExist::class)->duringExecute(
            new RequestModel('test-page', 'test-page-2')
        );
    }

    public function it_should_not_allow_slugs_to_be_renamed_to_taken_slugs()
    {
        $this->repository->save(Page::create('test-page', 'lorem', 'ipsum'));
        $this->repository->save(Page::create('test-page-2', 'lorem', 'ipsum'));

        $this->beConstructedWith($this->repository);
        $this->shouldThrow(SlugAlreadyTaken::class)->duringExecute(
            new RequestModel('test-page', 'test-page-2')
        );
    }

    public function it_should_not_allow_the_old_slug_to_be_accessible()
    {
        $this->repository->save(Page::create('test-page', 'lorem', 'ipsum'));

        $this->beConstructedWith($this->repository);
        $this->execute(new RequestModel('test-page', 'test-page-2'))->shouldBeLike(
            new ResponseModel('test-page-2')
        );
    }

    public function it_should_allow_slugs_to_be_renamed()
    {
        $this->repository->save(Page::create('test-page', 'lorem', 'ipsum'));

        $this->beConstructedWith($this->repository, Slug::fromString('test-page'), Slug::fromString('test-page-2'));
        $this->execute(new RequestModel('test-page', 'test-page-2'))->shouldBeLike(
            new ResponseModel('test-page-2')
        );
    }
}
