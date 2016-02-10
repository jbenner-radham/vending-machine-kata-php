<?php

namespace tests\Kata;

use Kata\VendingMachine;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VendingMachineSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kata\VendingMachine');
    }

    function it_should_accept_nickels()
    {
        $this->acceptCoin(VendingMachine::NICKEL)->shouldReturn(['message' => '$0.05', 'balance' => '$0.05']);
    }

    function it_should_accept_dimes()
    {
        $this->acceptCoin(VendingMachine::DIME)->shouldReturn(['message' => '$0.10', 'balance' => '$0.10']);
    }

    function it_should_accept_quarters()
    {
        $this->acceptCoin(VendingMachine::QUARTER)->shouldReturn(['message' => '$0.25', 'balance' => '$0.25']);
    }

    function it_should_reject_pennys()
    {
        $this->acceptCoin(VendingMachine::PENNY)->shouldReturn(['message' => 'INSERT COIN', 'balance' => '$0.00', 'rejected' => '$0.01']);
    }
}
