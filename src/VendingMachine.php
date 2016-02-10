<?php

namespace Kata;

use InvalidArgumentException;

class VendingMachine
{
    /** @var float */
    const DIME = .10;

    /** @var float */
    const NICKEL = .05;

    /** @var float */
    const QUARTER = .25;

    /** @var float[]  */
    protected $_coinage = [];

    protected function _getBalance(): float
    {
        if (empty($this->_coinage)) {
            return 0;
        }

        return array_sum($this->_coinage);
    }

    public function acceptCoin(float $coin)
    {
        switch ($coin) {
            case self::DIME:
            case self::NICKEL:
            case self::QUARTER:
                $this->_coinage[] = $coin;
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
}
