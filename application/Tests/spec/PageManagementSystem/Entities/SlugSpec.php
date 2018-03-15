<?php

namespace spec\PageManagementSystem\Entities;

use PageManagementSystem\Entities\Slug;
use PageManagementSystem\Entities\Exceptions\SlugCannotBeEmpty;
use PageManagementSystem\Entities\Exceptions\SlugHasNoAlphanumericCharacters;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlugSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Slug::class);
    }

    public function it_cannot_be_empty()
    {
        $this->beConstructedThrough('fromString', ['']);
        $this->shouldThrow(SlugCannotBeEmpty::class)->duringInstantiation();
    }

    public function it_must_have_an_alphanumeric_character()
    {
        $this->beConstructedThrough('fromString', ['    &()&%^$££"!@|/#']);
        $this->shouldThrow(SlugHasNoAlphanumericCharacters::class)->duringInstantiation();
    }

    public function it_converts_upper_case_to_lower_case()
    {
        $this->beConstructedThrough('fromString', ['TEST']);
        $this->__toString()->shouldBeLike('test');
    }

    public function it_strips_spaces()
    {
        $this->beConstructedThrough('fromString', ['TEST    PERSON']);
        $this->__toString()->shouldBeLike('test-person');
    }

    public function it_only_keeps_alphanumeric_characters_and_hyphens()
    {
        $this->beConstructedThrough('fromString', ['123 TEST_ TEST@&*^()£"456']);
        $this->__toString()->shouldBeLike('123-test-test-456');
    }
}
