<?php

namespace tests\Kata;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VendingMachineSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kata\VendingMachine');
    }
}
