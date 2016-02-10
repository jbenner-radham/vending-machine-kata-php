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

    function it_should_sell_cola_for_one_dollar()
    {
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->selectProduct(VendingMachine::COLA)->shouldReturn(['message' => 'THANK YOU', 'balance' => '$0.00']);
    }

    function it_should_sell_chips_for_fifty_cents()
    {
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->selectProduct(VendingMachine::CHIPS)->shouldReturn(['message' => 'THANK YOU', 'balance' => '$0.00']);
    }

    function it_should_sell_candy_for_sixty_five_cents()
    {
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->acceptCoin(VendingMachine::DIME);
        $this->acceptCoin(VendingMachine::NICKEL);
        $this->selectProduct(VendingMachine::CANDY)->shouldReturn(['message' => 'THANK YOU', 'balance' => '$0.00']);
    }

    function it_should_display_insert_coin_and_a_zero_balance_if_checked_after_purchase()
    {
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->acceptCoin(VendingMachine::QUARTER);
        $this->selectProduct(VendingMachine::CHIPS);
        $this->checkDisplay()->shouldReturn(['message' => 'INSERT COIN', 'balance' => '$0.00']);
    }

    function it_should_display_the_price_of_the_item_if_not_enough_money_was_inserted()
    {
        $this->acceptCoin(VendingMachine::NICKEL);
        $this->selectProduct(VendingMachine::CANDY)->shouldReturn(['message' => 'PRICE $0.65', 'balance' => '$0.05']);
    }

    function it_should_display_insert_coin_if_no_money_was_inserted()
    {
        $this->checkDisplay()->shouldReturn(['message' => 'INSERT COIN', 'balance' => '$0.00']);
    }
}
