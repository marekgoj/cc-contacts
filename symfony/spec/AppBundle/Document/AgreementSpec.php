<?php

namespace spec\AppBundle\Document;

use AppBundle\Document\Agreement;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AgreementSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Agreement::class);
    }

    function it_should_get_set_number()
    {
        $this->setNumber('12345');
        $this->getNumber()->shouldReturn('12345');
    }

    function it_should_get_set_date_of_signing()
    {
        $this->setDateOfSigning('2017-01-01');
        $this->getDateOfSigning()->shouldReturn('2017-01-01');
    }
}
