<?php

namespace Kata;

use InvalidArgumentException;

class VendingMachine
{
    use LogicTrait, MonetaryTrait, OperationalTrait;

    /** @var float */
    const CANDY = .65;

    /** @var float */
    const CHIPS = .50;

    /** @var float */
    const COLA = 1.00;

    /** @var float */
    const DIME = .10;

    /** @var float */
    const NICKEL = .05;

    /** @var float */
    const PENNY = .01;

    /** @var float */
    const QUARTER = .25;

    /** @var int */
    const STATE_NO_OP = 0;

    /** @var int */
    const STATE_DISPENSE = 1;

    /** @var int */
    const STATE_INSUFFICIENT_BALANCE = 2;

    /** @var float */
    protected $_balance = 0;

    /** @var float[]  */
    protected $_bank = [VendingMachine::DIME, VendingMachine::NICKEL, VendingMachine::QUARTER];

    /** @var float[] */
    protected $_inventory = [self::CANDY, self::CHIPS, self::COLA];

    /** @var int */
    protected $_state = self::STATE_NO_OP;

    public function acceptCoin(float $coin): array
    {
        if ($coin == VendingMachine::PENNY) {
            return $this->checkDisplay() + ['rejected' => sprintf('$%.2f', $coin)];
        }

        $acceptedCoins = [self::DIME, self::NICKEL, self::QUARTER];

        if (!in_array($coin, $acceptedCoins)) {
            throw new InvalidArgumentException('Invalid coin type received.');
        }

        $this->_balance += $coin;
        $this->_bank[]   = $coin;

        return $this->checkDisplay();
    }

    public function acceptCoins(array $coins): array
    {
        foreach ($coins as $coin) {
            $this->acceptCoin($coin);
        }

        return $this->checkDisplay();
    }

    public function checkDisplay(string $message = null): array
    {
        if (empty($this->_bank)) {
            $message = 'EXACT CHANGE ONLY';
        }

        return [
            'message' => $message ?? $this->_getMessage(),
            'balance' => sprintf('$%.2f', $this->_balance)
        ];
    }

    public function emptyBank(): self
    {
        $this->_bank = [];

        return $this;
    }

    public function returnCoins(): array
    {
        $this->_state = self::STATE_NO_OP;
        $display      = $this->checkDisplay();

        if ($display['balance'] !== '$0.00') {
            $display['message'] = 'INSERT COIN';
            $display['change']  = $display['balance'];
            $display['balance'] = '$0.00';
        }

        return $display;
    }

    public function selectProduct(float $product): array
    {
        $price = $product;

        if (!self::_isValidProduct($product)) {
            throw new InvalidArgumentException('Invalid product selected.');
        }

        if (!$this->_inInventory($product)) {
            return $this->_soldOut();
        }

        if ($price > $this->_balance) {
            return $this->_insufficientBalance($price);
        }

        #if (!empty($this->_makeChange($product))) {
        #    dump($this->_makeChange($product));
        #}

        return $this->_vendProduct($product);
    }
}
