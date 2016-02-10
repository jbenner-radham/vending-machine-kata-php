<?php

namespace Kata;

use InvalidArgumentException;

class VendingMachine
{
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

    /** @var float[]  */
    protected $_coinage = [];

    /** @var int */
    protected $_state = self::STATE_NO_OP;

    protected function _getBalance(): float
    {
        if (empty($this->_coinage)) {
            return 0;
        }

        return array_sum($this->_coinage);
    }

    public function acceptCoin(float $coin): array
    {
        switch ($coin) {
            case self::DIME:
            case self::NICKEL:
            case self::QUARTER:
                $this->_coinage[] = $coin;
                break;

            case self::PENNY:
                return $this->checkDisplay() + ['rejected' => sprintf('$%.2f', $coin)];
                break;

            default:
                throw new InvalidArgumentException('Invalid coin type received.');
        }

        return $this->checkDisplay();
    }

    public function checkDisplay(string $message = null): array
    {
        return ['message' => $message ?? $this->getMessage(), 'balance' => sprintf('$%.2f', $this->_getBalance())];
    }

    public function getMessage(string $message = null, float $money = null): string
    {
        if (!$message && !$money) {
            if ($this->_getBalance() == 0) {
                return 'INSERT COIN';
            }

            return sprintf('$%.2f', $this->_getBalance());
        }

        if ($money) {
            $message .= sprintf('$%.2f', $money);
        }

        return $message;
    }

    public function selectProduct(float $product): array
    {
        $cost      = $product;
        $inventory = [self::CANDY, self::CHIPS, self::COLA];

        if (!in_array($product, $inventory)) {
            throw new InvalidArgumentException('Invalid product selected.');
        }

        if ($cost > $this->_getBalance()) {
            if ($this->_state === self::STATE_INSUFFICIENT_BALANCE) {
                return $this->checkDisplay('INSERT COIN');
            }

            $this->_state = self::STATE_INSUFFICIENT_BALANCE;

            return $this->checkDisplay($this->getMessage('PRICE ', $cost));
        }

        $this->_coinage = [];
        $this->_state   = self::STATE_DISPENSE;

        return $this->checkDisplay('THANK YOU');
    }
}
