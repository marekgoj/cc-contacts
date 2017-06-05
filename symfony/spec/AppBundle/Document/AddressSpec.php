<?php

namespace spec\AppBundle\Document;

use AppBundle\Document\Address;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Address::class);
    }

    function it_should_set_get_address()
    {
        $this->setAddress('Mariacka 12/3');
        $this->getAddress()->shouldReturn('Mariacka 12/3');
    }

    function it_should_set_get_city()
    {
        $this->setCity('Katowice');
        $this->getCity()->shouldReturn('Katowice');
    }

    function it_should_set_get_type()
    {
        $this->setType($this->getWrappedObject()::TYPE_HOME);
        $this->getType()->shouldReturn($this->getWrappedObject()::TYPE_HOME);
    }

    function it_should_throw_exception_when_setting_wrong_type()
    {
        $this->shouldThrow('InvalidArgumentException')->during('setType', ['wrongType']);
    }

    function it_should_create_from_array()
    {
        $address = [
            'address' => 'Mariacka 12/3',
            'city' => 'Katowice',
            'type' => Address::TYPE_HOME
        ];
        $this->createFromArray($address)->shouldReturnAnInstanceOf('AppBundle\Document\Address');
    }
}
