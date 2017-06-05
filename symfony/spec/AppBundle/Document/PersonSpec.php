<?php

namespace spec\AppBundle\Document;

use AppBundle\Document\Person;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Prophet;

class PersonSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Person::class);
    }

    function it_has_first_name()
    {
        $this->setFirstName('John');
        $this->getFirstName()->shouldReturn('John');
    }

    function it_has_last_name()
    {
        $this->setLastName('Smith');
        $this->getLastName()->shouldReturn('Smith');
    }

    function it_has_phone()
    {
        $this->setPhone('123-45-67');
        $this->getPhone()->shouldReturn('123-45-67');
    }

    function it_has_addresses()
    {
        $addressColl = (new Prophet())->prophesize('AppBundle\Document\AddressCollection')->reveal();
        $this->setAddresses($addressColl);
        $this->getAddresses()->shouldReturn($addressColl);
    }
}
