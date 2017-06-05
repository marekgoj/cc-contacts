<?php

namespace spec\AppBundle\Document;

use AppBundle\Document\Address;
use AppBundle\Document\AddressCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Prophet;

class AddressCollectionSpec extends ObjectBehavior
{
    /** @var  Prophet */
    protected $prophet;

    function __construct()
    {
        $this->prophet = new Prophet();
    }

    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddressCollection::class);
    }

    function it_extends_array_collection()
    {
        $this->shouldImplement('Doctrine\Common\Collections\ArrayCollection');
    }

    function it_should_throw_exception_when_add_no_address()
    {
        $this->shouldThrow('InvalidArgumentException')->during('add', [null]);
    }

    function it_should_allow_add_address()
    {
        $address = $this->prophet->prophesize('AppBundle\Document\Address')->reveal();
        $this->add($address)->shouldReturn(true);

        $this->count()->shouldReturn(1);
    }


}
